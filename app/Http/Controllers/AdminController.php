<?php

namespace App\Http\Controllers;

use App\Mail\SendBankTransferEmail;
use App\Mail\SendWinnersEmail;
use App\Models\AdminNote;
use App\Models\BankTransfer;
use App\Models\Category;
use App\Models\Configure;
use App\Models\Contest;
use App\Models\ContestParticipants;
use App\Models\Faq;
use App\Models\ModelInfo;
use App\Models\Payment;
use App\Models\SaveFilter;
use App\Models\User;
use App\Services\ContestService;
use App\Services\ModelsService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class AdminController extends Controller
{
    public function add_category()
    {
        $arr = [1,2,3,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48,50,52,54,56,58,60,62,64,66,68,70];
        $data = Category::all();
        return view('admin.add_category', compact('data', 'arr'));
    }

    public function add_category_post(Request $request)
    {
        $request->validate([
            'cate_name' => 'required',
            'gender' => 'required',
        ], [
            'cate_name.required' => 'Category title is required.',
            'gender.required' => 'Please choose at least one gender.'
        ]);
        $category = new Category;

        $category->title = $request->cate_name;

        $category->_age = $request->age_from . ',' . $request->age_to;
        $category->_height = $request->height_from . ',' . $request->height_to;
        $category->_gender = implode(',', $request->gender);
        $category->_dress = is_array($request->dress_size) ? implode(',', $request->dress_size) : '';

        $category->save();

        return redirect()->back();

    }

    public function category_delete($id)
    {
        Category::where('id', $id)->delete();

        return redirect()->back();
    }

    public function add_contest()
    {
        $data = Category::all();
        $contests = Category::with(['contests' => function($query) {
            $query->withCount('user_participants');
            $query->where('end', '>', Carbon::today()->format('Y-m-d'));
        }])
            ->has('contests', '>', 0)
            ->whereHas('contests', function ($query) {
                $query->whereNotNull('title');
            })
            ->get();

        $contests = $contests->filter(function ($category) {
            return $category->contests->isNotEmpty();
        });

        return view('admin.add_contest', compact('data', 'contests'));
    }

    public function add_contest_post(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'contest_name' => 'required',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'contest_price_first' => 'required|numeric',
            'contest_price_second' => 'required|numeric',
            'contest_price_third' => 'required|numeric',
            'rules' => 'required'
        ]);

            $category = Category::where('id', '=', $request->category)->first();

            $height = explode(',', $category->_height);
            $height_from = $height[0] ?? 0.0;
            $height_to = $height[1] ?? 5000.0;

            $user_ids = User::with(['portfolio' => function($query) {
                $query->select('user_id', 'file_name', 'ext');
            }])
                ->select('id')
                ->whereIn('gender', explode(',', $category->_gender))
                //->whereBetween('age', [$age_from, $age_to])
                ->when($category->_dress != null, function ($q) use($category) {
                    $q->whereIn('dress', explode(',', $category->_dress));
                })
                ->when($height_from != null && $height_to != null, function ($q) use($height_from, $height_to) {
                    $q->whereIn('height', [$height_from, $height_to]);
                })
                ->whereHas('portfolio', function ($query) {
                    $query->whereNotNull('file_name');
                })->get();

            //return $user_ids;

            if(count($user_ids) > 1)
            {
                $contest = new Contest;

                $contest->title = $request->contest_name;
                $contest->start = $request->date_from;
                $contest->category_id = $request->category;
                $contest->end = $request->date_to;
                $contest->prize_first = $request->contest_price_first;
                $contest->prize_second = $request->contest_price_second;
                $contest->prize_third = $request->contest_price_third;
                $contest->rules = $request->rules;
                $contest->save();

                $participants = $user_ids->map(function ($uid) use ($contest) {
                    return [
                        'contest_id' => $contest->id,
                        'user_id' => $uid->id
                    ];
                })->toArray();

                ContestParticipants::insert($participants);

                return redirect()->back();
            } else
            {
                return 'No model found in this category.';
            }



    }

    public function contest_delete($id)
    {
        Contest::where('id', $id)->delete();
        return redirect()->back();
    }

    public function winners(ContestService $contestService, Request $request)
    {
        $data = $contestService->getWinners();
        return view('admin.winners', compact('data', 'request'));
    }

    public function contest_dashboard()
    {
        $totalParticipantsByCategory = DB::table('contests')
            ->join('categories', 'contests.category_id', '=', 'categories.id')
            ->select('categories.title', 'categories.id as category_id',
                DB::raw('SUM((SELECT COUNT(id) FROM contest_participants WHERE contest_participants.contest_id = contests.id)) as total_participants'),
                DB::raw('AVG(prize_first) as average_prize_first'),
                DB::raw('AVG(prize_second) as average_prize_second'),
                DB::raw('AVG(prize_third) as average_prize_third'))
            ->groupBy('categories.title')
            ->get()
            ->groupBy('title')
            ->map(function ($contests) {
                return [
                    'category_id' => $contests[0]->category_id,
                    'category_title' => $contests[0]->title,
                    'total_participants' => $contests->sum('total_participants'),
                    'average_prize_first' => $contests->avg('average_prize_first'),
                    'average_prize_second' => $contests->avg('average_prize_second'),
                    'average_prize_third' => $contests->avg('average_prize_third'),
                ];
            })
            ->toArray();

        return view('admin.contest_dashboard', compact('totalParticipantsByCategory'));
    }

    public function category_contests(ContestService $contestService): Factory|View|Application
    {
        $contests = Contest::with(['category'])
            ->where('end', '>', Carbon::today()->format('Y-m-d'))
            ->paginate(20);

        return view('admin.category_contest', compact('contests'));
    }

    public function contest_stats(ContestService $contestService, int $contestId)
    {
        $final_results = $contestService->contestStats($contestId);
        return view('admin.contest_stats', compact('final_results'));
    }

    public function stats(ContestService $contestService, Request $request): Factory|View|Application
    {
        $time_from = Carbon::today()->format('Y-m-d');
        $time_to = Carbon::today()->format('Y-m-d');

        if ($request->isMethod('post')) {
            if ($request->time == '1x') {
                $time_from = Carbon::today()->format('Y-m-d');
                $time_to = Carbon::today()->format('Y-m-d');
            } elseif ($request->time == '2x') {
                $time_from = Carbon::now()->startOfMonth()->format('Y-m-d');
                $time_to = Carbon::now()->endOfMonth()->format('Y-m-d');
            } elseif ($request->time == '3x') {
                $time_from = Carbon::now()->startOfWeek()->format('Y-m-d');
                $time_to = Carbon::now()->endOfWeek()->format('Y-m-d');
            }
        }
        $users = $contestService->totalUsers($time_from, $time_to, $request->all());
        $totalSubscribers = $contestService->totalSubscribers($time_from, $time_to, $request->all());
        $totalIncome = $contestService->totalIncome($time_from, $time_to, $request->all());

        $data = [
            'users' => $users,
            'total_subscribers' => $totalSubscribers,
            'total_income' => $totalIncome,
        ];

        return view('admin.stats', compact('data'));
    }

    public function models(Request $request, ModelsService $modelsService, int $id = 0)
    {
        $data = [];
        $admin_note = [];

        $saveFilters = SaveFilter::all();

        if ($request->has('s')) {
            $request->validate([
                'keyword' => '',
                'filter_one' => $request->filled('keyword') ? 'nullable' : 'required',
                'filter_two' => $request->filled('keyword') ? 'nullable' : 'required'
            ], [
                'filter_one.required' => 'Please choose one',
                'filter_two.required' => 'Please choose one'
            ]);
            $data = $modelsService->alphaOrder($request->all(), $request->query('alpha'));
            if(count($data) > 0) {
                $admin_note = AdminNote::whereToUserId($data[0]['uid'])
                    ->first();
            }

            //return $data;
        }

        return view('admin.models', compact('data', 'request', 'saveFilters', 'admin_note'));
    }

    public function models_info(ModelsService $modelsService, int $id)
    {
        $model_info = $modelsService->modelInfo($id);

        return view('admin.models_info', compact('model_info'));
    }

    public function model_rate(int $rate, int $uid): RedirectResponse
    {
        ModelInfo::updateOrInsert(
            ['user_id' => $uid, 'key' => 'rate'],
            ['user_id' => $uid, 'key' => 'rate', 'value' => $rate]
        );

        return redirect()->back();
    }

    public function model_heart(int $status, int $uid): RedirectResponse
    {
        ModelInfo::updateOrInsert(
            ['user_id' => $uid, 'key' => 'love'],
            ['user_id' => $uid, 'key' => 'love', 'value' => $status]
        );

        return redirect()->back();
    }

    public function model_status(int $uid, int $status): RedirectResponse
    {
        if($status === 1)
        {
            User::whereId($uid)
                ->update(['status' => 1]); // Approve
        } else
        {
            User::whereId($uid)
                ->update(['status' => 2]); // Hide
        }

        return redirect()->back();
    }

    public function save_filter(Request $request): RedirectResponse
    {
        $params = [
            'gender[]' => $request->input('gender'),
            'civil[]' => $request->input('civil'),
            'age_from' => $request->input('age_from'),
            'age_to' => $request->input('age_to'),
        ];

        $queryString = http_build_query($params);

        $save = new SaveFilter;
        $save->title = $request->input('title');
        $save->url = $queryString;
        $save->save();

        return redirect()->back();
    }

    public function filter_delete(int $id): \Illuminate\Routing\Redirector|Application|RedirectResponse
    {
        SaveFilter::whereId($id)
            ->delete();

        return redirect()->back();
    }

    public function subscribers(Request $request)
    {
        $users = User::whereHas('payment', function ($query) use ($request) {
            if (isset($request->status) && $request->status == '1') {
                $query->where('end_date', '>', Carbon::today()->format('Y-m-d')); // active
            } elseif (!isset($request->status)) {
                $query->where('end_date', '>', Carbon::today()->format('Y-m-d')); // active
            } else {
                $query->where('end_date', '<', Carbon::today()->format('Y-m-d')); // inactive
            }
        })
            ->with(['payment' => function ($query) use ($request) {
                if (isset($request->status) && $request->status == '1') {
                    $query->where('end_date', '>', Carbon::today()->format('Y-m-d')); // active
                } elseif (!isset($request->status)) {
                    $query->where('end_date', '>', Carbon::today()->format('Y-m-d')); // active
                } else {
                    $query->where('end_date', '<', Carbon::today()->format('Y-m-d')); // inactive
                }
            }])
            ->when(isset($request->gender), function ($query) use ($request) {
                $query->whereIn('gender', $request->gender);
            })
            ->when(isset($request->state), function ($query) use ($request) {
                $query->where('state', $request->state);
            })
            ->when(isset($request->city), function ($query) use ($request) {
                $query->whereIn('city', $request->city);
            })
            ->withSum('payment', 'amount');

        $payments = $users->paginate(20);
        $totalAmount = $payments->sum('payment_sum_amount');

        return view('admin.subscribers', compact('payments', 'totalAmount'));
    }

    public function faqs()
    {
        $faqs = Faq::paginate(10);
        return \view('admin.help', compact('faqs'));
    }

    public function faq_post(Request $request): RedirectResponse
    {
        $faq = new Faq;
        $faq->question = $request->q;
        $faq->answer = $request->a;
        $faq->save();

        return redirect()->back();
    }

    public function faq_delete(int $id): RedirectResponse
    {
        Faq::where('id', $id)
            ->delete();

        return redirect()->back();
    }

    public function winner_bank_transfer(int $contest_id, int $id, float $prize)
    {
        $data = Configure::with('user')
            ->where('user_id', $id)
            ->whereIn('key', ['bank', 'pix'])
            ->select('id', 'value', 'user_id')
            ->get();

        if (count($data) === 0) {
            return redirect(route('admin.winners'));
        }

        return \view('admin.bank-transfer', compact('data', 'contest_id', 'id', 'prize'));
    }

    public function bank_transfer_post(Request $request): \Illuminate\Routing\Redirector|Application|RedirectResponse
    {
        $user = User::whereId($request->_user)->select('id', 'email', 'name')->first();
        $contest = Contest::whereId($request->_contest)->select('title', 'id')->first();

        $config = Configure::where('key', $request->_bank)
            ->where('user_id', $request->_user)
            ->select('id', 'value')
            ->first();

        $save = new BankTransfer;
        $save->contest_id = $request->_contest;
        $save->user_id = $request->_user;
        $save->status = 1;
        $save->acc_no = $config->value;
        $save->save();

        if ($save->id) {
            $array_data = [
                'prize_money' => $request->_prize,
                'to' => $request->_bank == 'bank' ? 'PAGSEGURO' : 'PIX',
                'name' => $user->name,
                'contest_name' => $contest->title,
            ];
            Mail::to($user->email)->queue(new SendBankTransferEmail($array_data));
        }

        return redirect(route('admin.winners'));
    }

    public function contest_info_by_category(int $id)
    {
        $contests = Category::with(['contests' => function($query) use($id) {
            $query->withCount('user_participants');
            //$query->where('end', '>', Carbon::today()->format('Y-m-d'));
            $query->where('category_id', $id);
        }])
            ->has('contests', '>', 0)
            ->whereHas('contests', function ($query) {
                $query->whereNotNull('title');
            })
            ->where('id', $id)
            ->first();

//        $contests = $contests->filter(function ($category) {
//            return $category->contests->isNotEmpty();
//        });

        //return $contests;

        return response()->json($contests);
    }
}
