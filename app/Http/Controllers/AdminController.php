<?php

namespace App\Http\Controllers;

use App\Models\AdminNote;
use App\Models\Category;
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

class AdminController extends Controller
{
    public function add_category()
    {
        $data = Category::all();
        return view('admin.add_category', compact('data'));
    }

    public function add_category_post(Request $request)
    {
        $category = new Category;

        $category->title = $request->cate_name;
        $category->age = $request->age_from . ',' . $request->age_to;
        $category->height = $request->height_from . ',' . $request->height_to;
        $category->gender = implode(',', $request->gender);
        $category->dress_size = $request->dress_size_from . ',' . $request->dress_size_to;

        //save into preferences column into json format
        $category->preferences = [
            'gender' => $request->gender,
            'dress_size' => $request->dress_size_fro . ',' . $request->dress_size_to
        ];

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
        try {
            $category = Category::where('id', $request->category)->first();

            $user_ids = User::with(['portfolio' => function($query) {
                $query->select('user_id', 'file_name', 'ext');
            }])
                ->select('id')
                ->whereIn('gender', explode(',', $category->gender))
                ->whereIn('civil', ['single'])
                ->whereHas('portfolio', function ($query) {
                    $query->whereNotNull('file_name');
                })
                ->get();

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
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
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

    public function models(Request $request, ModelsService $modelsService, int $id = 0): Factory|View|Application
    {
        $data = [];
        $admin_note = [];

        $saveFilters = SaveFilter::all();

        if ($request->has('s')) {
            $data = $modelsService->alphaOrder($request->all(), $request->query('alpha'));
            if(count($data) > 0) {
                $admin_note = AdminNote::whereToUserId($data[0]['uid'])
                    ->first();
            }
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
        $users = User::with(['payment' => function ($query) {
            $query->where('end_date', '>', Carbon::today()->format('Y-m-d'));
        }])->has('payment');

        if (isset($request->gender)) {
            $users->whereIn('gender', $request->gender);
        }
        if (isset($request->state)) {
            $users->where('state', $request->state);
        }
        if (isset($request->city)) {
            $users->whereIn('city', $request->city);
        }

        $payments = $users->paginate(20);

        return view('admin.subscribers', compact('payments'));
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
}
