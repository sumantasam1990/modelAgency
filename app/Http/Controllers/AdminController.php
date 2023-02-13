<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contest;
use App\Models\ContestParticipants;
use App\Models\ModelInfo;
use App\Models\User;
use App\Services\ContestService;
use App\Services\ModelsService;
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
        $category->skin_color = implode(',', $request->skin);
        $category->hair_color = implode(',', $request->hair);
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
        }])
            ->whereHas('contests', function ($query) {
                $query->whereNotNull('title');
            })
            ->get();

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

    public function category_contests(ContestService $contestService, int $cateId): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $contests = Contest::with(['category'])
            ->where('category_id', $cateId)
            ->get();

        return view('admin.category_contest', compact('contests'));
    }

    public function contest_stats(ContestService $contestService, int $contestId)
    {
        $final_results = $contestService->contestStats($contestId);
        return view('admin.contest_stats', compact('final_results'));
    }

    public function stats(ContestService $contestService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $data = [];
        $users = $contestService->totalUsers();
        $categories = $contestService->totalCategories();
        $activeContests = $contestService->totalActiveContests();
        $inactiveContests = $contestService->totalInactiveContests();
        $participants = $contestService->totalParticipants();

        $data = [
            'users' => $users,
            'categories' => $categories,
            'active_contests' => $activeContests,
            'inactive_contests' => $inactiveContests,
            'participants' => $participants,
        ];

        return view('admin.stats', compact('data'));
    }

    public function models(Request $request, ModelsService $modelsService, int $id = 0)
    {
        $model_info = [];

        $data = $modelsService->alphaOrder($request->all(), $request->query('alpha'));

        if($id > 0)
        {
            $model_info = $modelsService->modelInfo($id);
        }

        return $model_info;

        return view('admin.models', compact('data', 'model_info', 'request'));
    }

    public function model_rate(int $rate): \Illuminate\Http\RedirectResponse
    {
        $rating = new ModelInfo;

        $rating->user_id = auth()->user()->id;
        $rating->key = 'rate';
        $rating->value = $rate;
        $rating->save();

        return redirect()->back();
    }
}
