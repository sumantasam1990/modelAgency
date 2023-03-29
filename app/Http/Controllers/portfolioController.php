<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\ContestParticipants;
use App\Models\Interest;
use App\Models\Link;
use App\Models\portfolio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class portfolioController extends Controller
{
    public function index(int $contest_id = 0)
    {
        $minutes = 86400;
        $data = Cache::remember('photo-user-' . Auth::id(), $minutes, function () {
            return User::with('portfolios')->where('id', Auth::user()->id)->first();
        });
        //$data = User::with('portfolios')->where('id', Auth::user()->id)->first();

//        $links_jobs = Link::where('user_id', Auth::user()->id)->where('key', 'jobs')->get();
//        $links_awards = Link::where('user_id', Auth::user()->id)->where('key', 'awards')->get();
//        $links_dance = Link::where('user_id', Auth::user()->id)->where('key', 'dance')->get();
//        $links_music = Link::where('user_id', Auth::user()->id)->where('key', 'music')->get();
//        $links_drama = Link::where('user_id', Auth::user()->id)->where('key', 'drama')->get();
//        $links_sport = Link::where('user_id', Auth::user()->id)->where('key', 'sport')->get();

        return view('portfolio.index', [
            'data' => $data,
            'contest_id' => $contest_id,
//            'links_jobs' => $links_jobs,
//            'links_awards' => $links_awards,
//            'links_dance' => $links_dance,
//            'links_music' => $links_music,
//            'links_drama' => $links_drama,
//            'links_sport' => $links_sport
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,webp,png|max:1024',
        ]);

        Cache::delete('photo-user-' . Auth::user()->id);

        if ($request->has('image')) {

            $uniqName = 'model_' . uniqid() . time();
            $imageName = $uniqName . '.' . $request->image->extension();
            //$request->image->move(public_path('uploads'), $imageName);

            $request->file('image')->storeAs('image', $imageName, 'public');

            try {
                $images = portfolio::where('user_id', Auth::user()->id)->count();
                if($images < 12)
                {
                    $image = new portfolio;
                    $image->file_name = $uniqName;
                    $image->ext = $request->image->extension();
                    $image->user_id = Auth::user()->id;
                    $image->save();

                    if ($images === 0)
                    {
                        portfolio::where('id', $image->id)
                            ->update(['profile_photo' => 1, 'contest_photo' => 1]);
                    }

                    return back()->with('msg', 'Your photo has been uploaded successfully.');
                } else {
                    return back()->with('err', "You won't upload more than 12 photos.");
                }
            } catch (\Throwable $th) {
                return back()
                    ->with('err', 'Error! ' . $th->getMessage() . ' - '. $th->getCode());
            }
        }
    }

    public function links_post(Request $request)
    {
        Link::updateOrCreate(
            ['user_id' => Auth::user()->id, 'key' => 'jobs'],
            ['title' => $request->job_title, 'url' => $request->job_url, 'key' => 'jobs', 'user_id' => Auth::user()->id]
        );

        Link::updateOrCreate(
            ['user_id' => Auth::user()->id, 'key' => 'awards'],
            ['title' => $request->award_title, 'url' => $request->award_url, 'key' => 'awards', 'user_id' => Auth::user()->id]
        );

        Link::updateOrCreate(
            ['user_id' => Auth::user()->id, 'key' => 'dance'],
            ['title' => $request->dance_title, 'url' => $request->dance_url, 'key' => 'dance', 'user_id' => Auth::user()->id]
        );

        Link::updateOrCreate(
            ['user_id' => Auth::user()->id, 'key' => 'music'],
            ['title' => $request->music_title, 'url' => $request->music_url, 'key' => 'music', 'user_id' => Auth::user()->id]
        );

        Link::updateOrCreate(
            ['user_id' => Auth::user()->id, 'key' => 'drama'],
            ['title' => $request->drama_title, 'url' => $request->drama_url, 'key' => 'drama', 'user_id' => Auth::user()->id]
        );

        Link::updateOrCreate(
            ['user_id' => Auth::user()->id, 'key' => 'sport'],
            ['title' => $request->sport_title, 'url' => $request->sport_url, 'key' => 'sport', 'user_id' => Auth::user()->id]
        );

        return back()->with('msg', 'Links added successfully.');
    }

    public function delete_photo($id): string|\Illuminate\Http\RedirectResponse
    {
        try {
            Cache::delete('photo-user-' . Auth::user()->id);
            $avatar = portfolio::findOrFail($id);
            if(Storage::delete('public/image/' . $avatar->file_name . '.' . $avatar->ext)) {
                $avatar->delete();
            }

            return back()->with("msg", "Photo deleted successfully.");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function add_interest(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'interest' => 'required|max:250'
        ]);

        Interest::updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['content' => $request->interest, 'user_id' => Auth::user()->id]
        );

        return back()->with('msg', 'Interest added successfully.');
    }

    public function mark_profile_photo(int $id): \Illuminate\Http\RedirectResponse
    {
        Cache::delete('photo-user-' . Auth::user()->id);

        portfolio::whereUserId(Auth::user()->id)
            ->update(['profile_photo' => 0]);

        portfolio::whereId($id)
            ->update(['profile_photo' => 1]);

        return redirect()->back();
    }

    public function mark_contest_photo(int $id, int $contest_id = 0)
    {
        Cache::delete('photo-user-' . Auth::user()->id);
        Cache::delete('user-' . Auth::user()->id);

        if (Contest::where('start', '>=', now())->where('id', $contest_id)->count('id') === 0) {
            return redirect()->back()->with('err', 'You can not change your photo for this contest. Because It is already started.');
        }

        $photo = portfolio::where('id', $id)
            ->select('id', 'file_name', 'ext')
            ->get();

        if (count($photo) > 0) {
            ContestParticipants::where('contest_id', $contest_id)
                ->where('user_id', Auth::user()->id)
                ->update(['contest_photo' => $photo[0]->file_name . '.' . $photo[0]->ext]);
        }

        return redirect()->back();
    }
}
