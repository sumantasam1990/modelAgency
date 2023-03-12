<?php

namespace App\Http\Controllers;

use App\Models\Configure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile($username)
    {
        $data = User::with(['portfolio', 'portfolios', 'state_name'])->where('username', $username)->first();

        $userid_get = User::where('username', $username)->select('id')->first();
        $userId = $userid_get->id; // specify the user ID here

        $result = DB::table('contest_voting_results')
            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->join('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
            ->join('portfolios', 'portfolios.user_id', 'users.id')
            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'users.name as user_name', 'users.username as username',
                DB::raw('SUM(vote_count) as total_votes'), 'portfolios.file_name', 'portfolios.ext')
            ->where('whom_vote', $userId)
            ->where('portfolios.profile_photo', 1)
            ->groupBy('contest_id', 'whom_vote')
            ->orderByDesc('total_votes')
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                return [
                    'contest_id' => $group->first()->contest_id,
                    'contest_name' => $group->first()->contest_name,
                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
                    'winners' => $group->take(3)->map(function ($item) {
                        return [
                            'username' => $item->username,
                            'user_name' => $item->user_name,
                            'user_image' => [
                                'image_path' => $item->file_name . '.' . $item->ext,
                            ],
                            'total_votes' => $item->total_votes,
                        ];
                    })
                ];
            });

        $contestsWon = $result->count();

        return view('profile.profile', compact('data', 'contestsWon'));
    }

    public function edit_profile()
    {
        $arr = [1,2,3,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48,50,52,54,56,58,60,62,64,66,68,70];
        $user = User::with(['configure_bank', 'configure_pix'])->whereId(Auth::user()->id)->first();
        return view('profile.edit', compact('user', 'arr'));
    }

    public function update_profile(Request $request)
    {
        $preferences = [
            'social' => [
                'insta' => [
                    'label' => $request->social_insta_label,
                    'url' => $request->social_insta_url,
                    'follower' => $request->social_insta_follow,
                ],
                'tiktok' => [
                    'label' => $request->social_tiktok_label,
                    'url' => $request->social_tiktok_url,
                    'follower' => $request->social_tiktok_follow,
                ],
                'other' => [
                    'label' => $request->social_other_label,
                    'url' => $request->social_other_url,
                    'follower' => $request->social_other_follow,
                ]
            ]
        ];

        User::whereId(Auth::user()->id)
            ->update([
                'name' => $request->_name,
                'state' => $request->state,
                'city' => $request->city[0],
                'district' => $request->_district,
                'wp' => $request->_wp,
                'gender' => $request->_gender,
                'civil' => $request->_civil_status,
                'height' => (float)$request->_height,
                'age' => $request->_age,
                'skin' => $request->_skin,
                'bust' => $request->bust,
                'waist' => $request->waist,
                'hips' => $request->hips,
                'dress' => $request->dress,
                'hair' => $request->hair,
                'eyes' => $request->eyes,
                'other' => implode(',', $request->other),
                'preferences' => $preferences,
            ]);

        if ($request->bank != '')
        {
            DB::table('configures')->updateOrInsert(
                ['user_id' => Auth::user()->id, 'key' => 'bank'],
                ['value' => $request->bank]
            );
        }
        if ($request->pix != '')
        {
            DB::table('configures')->updateOrInsert(
                ['user_id' => Auth::user()->id, 'key' => 'pix'],
                ['value' => $request->pix]
            );
        }

        return redirect()->back();
    }
}
