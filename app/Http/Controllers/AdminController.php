<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contest;
use App\Models\ContestParticipants;
use App\Models\User;
use Illuminate\Http\Request;

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

            foreach ($user_ids as $uid)
            {
                $participants = new ContestParticipants;
                $participants->contest_id = $contest->id;
                $participants->user_id = $uid->id;
                $participants->save();
            }

            return redirect()->back();
        }
    }

    public function contest_delete($id)
    {
        Contest::where('id', $id)->delete();

        return redirect()->back();
    }
}
