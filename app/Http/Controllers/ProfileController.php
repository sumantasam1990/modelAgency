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

        $contestsWon = DB::table('winners')
            ->where('rank', '>', 0)
            ->where('rank', '<', 4)
            ->where('user_id', '=', $userId)
            ->where('total_votes', '>', 0)
            ->count();

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

    public function about_me()
    {
        return view('profile.about');
    }

    public function about_post(Request $request)
    {
        DB::table('users')->updateOrInsert(
            ['id' => Auth::user()->id],
            ['about' => $request->about]
        );

        return redirect()->back()->with('msg', 'Saved successfully.');
    }
}
