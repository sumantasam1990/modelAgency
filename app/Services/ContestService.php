<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Contest;
use App\Models\ContestParticipants;
use App\Models\ContestVotingResult;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ContestService
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder|User|\Illuminate\Database\Query\Builder $users
     * @return int
     */
    private function extracted(\Illuminate\Database\Eloquent\Builder|User|\Illuminate\Database\Query\Builder $users, $request): int
    {
        if (isset($request['gender'])) {
            $users->whereIn('gender', $request['gender']);
        }
        if (isset($request['state'])) {
            $users->where('state', $request['state']);
        }
        if (isset($request['city'])) {
            $users->whereIn('city', $request['city']);
        }
        if (isset($request['age_from'])) {
            $users->whereBetween('users.preferences->_age', [$request['age_from'], $request['age_to']]);
        }
        if (isset($request['h_from'])) {
            $users->whereBetween(DB::raw("CAST(json_extract(`users`.`preferences`, '$._height') AS UNSIGNED)"), [$request['h_from'], $request['h_to']]);
        }
        if (isset($request['_skin'])) {
            $users->where('users.preferences->_skin', $request['_skin']);
        }
        if (isset($request['dress'])) {
            $users->where('users.preferences->dress', $request['dress']);
        }
        if (isset($request['hair'])) {
            $users->where('users.preferences->hair', $request['hair']);
        }
        if (isset($request['eyes'])) {
            $users->where('users.preferences->eyes', $request['eyes']);
        }

        return $users->count('id');
    }

    public function totalUsers(String $from, String $to, $request): int
    {
        $users = User::where('email', '!=', 'admin@admin.com')
            ->where('status', 0)
            ->whereBetween('created_at', [$from, $to]);

        return $this->extracted($users, $request);
    }

    public function totalSubscribers(String $from, String $to, $request): int
    {
        $users = User::where('email', '!=', 'admin@admin.com')
            ->where('subscribed', 1)
            ->whereBetween('created_at', [$from, $to]);

        return $this->extracted($users, $request);
    }

    public function totalIncome(String $from, String $to, $request)
    {
        $sum = User::where('email', '!=', 'admin@admin.com')
            ->whereHas('payment', function ($query) use ($from, $to) {
                $query->whereBetween('start_date', [$from, $to]);
            })
            ->selectRaw('SUM(payments.amount) as total')
            ->leftJoin('payments', 'users.id', '=', 'payments.user_id');

        if (isset($request['gender'])) {
            $sum->whereIn('gender', $request['gender']);
        }
        if (isset($request['state'])) {
            $sum->where('state', $request['state']);
        }
        if (isset($request['city'])) {
            $sum->whereIn('city', $request['city']);
        }
        if (isset($request['age_from'])) {
            $sum->whereBetween('users.preferences->_age', [$request['age_from'], $request['age_to']]);
        }
        if (isset($request['h_from'])) {
            $sum->whereBetween(DB::raw("CAST(json_extract(`users`.`preferences`, '$._height') AS UNSIGNED)"), [$request['h_from'], $request['h_to']]);
        }
        if (isset($request['_skin'])) {
            $sum->where('users.preferences->_skin', $request['_skin']);
        }
        if (isset($request['dress'])) {
            $sum->where('users.preferences->dress', $request['dress']);
        }
        if (isset($request['hair'])) {
            $sum->where('users.preferences->hair', $request['hair']);
        }
        if (isset($request['eyes'])) {
            $sum->where('users.preferences->eyes', $request['eyes']);
        }


        return $sum->groupBy('users.id')
            ->pluck('total')
            ->sum();
    }

    public function totalCategories(): int
    {
        return Category::count('id');
    }

    public function totalActiveContests(): int
    {
        return Contest::where('end', '>=', Carbon::today()->toDateString())->count('id');
    }

    public function totalInactiveContests(): int
    {
        return Contest::where('end', '<', Carbon::today()->toDateString())->count('id');
    }

    public function totalParticipants(): int
    {
        return ContestParticipants::distinct('user_id')->count('id');
    }

    public function userContestPhoto()
    {
        $minutes = 86400;
        return Cache::remember('user-' . Auth::id(), 120, function () {
            return User::where('id', Auth::id())
                ->whereHas('portfolio_without_profile_photo', function ($query) {
                    $query->where('contest_photo', 1);
                })
                ->with(['portfolio_without_profile_photo' => function ($query) {
                    $query->where('contest_photo', 1);
                }])
                ->first();
        });
    }
    public function getContest(): \Illuminate\Database\Eloquent\Collection|array
    {
        $contestParticipants = ContestParticipants::where('user_id', Auth::user()->id)->select('contest_id')->get();
        $getAlreadyVotedUsers = ContestVotingResult::where('user_id', Auth::user()->id)->select('contest_id')->get();
        return Contest::with('users.portfolio')
            ->whereNotIn('id', $getAlreadyVotedUsers)
            ->whereNotIn('id', $contestParticipants)
            ->where('end', '>', Carbon::today()->format('Y-m-d'))
            ->take(1)
            ->get();
    }

    public function vote($contestId, $modelId)
    {
        $voting = new ContestVotingResult;
        $voting->contest_id = $contestId;
        $voting->user_id = Auth::user()->id;
        $voting->whom_vote = $modelId;
        $voting->vote_count = 1;
        $voting->save();

        return $voting->id;
    }

    public function my_contests()
    {
//        return DB::table('contest_voting_results')
//            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
//            ->join('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
//            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'users.name as user_name',
//                DB::raw('SUM(vote_count) as total_votes'))
//            ->where('users.id', \auth()->user()->id)
//            ->groupBy('contest_id', 'whom_vote')
//            ->orderBy('contest_id')
//            ->orderByDesc('total_votes')
//            ->get()
//            ->groupBy('contest_id')
//            ->map(function ($group) {
//                return [
//                    'contest_id' => $group->first()->contest_id,
//                    'contest_name' => $group->first()->contest_name,
//                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
//                    'winners' => $group->take(3)->map(function ($item) {
//                        return [
//                            'user_name' => $item->user_name,
//                            'total_votes' => $item->total_votes,
//                        ];
//                    })
//                ];
//            });

        return Contest::join('contest_participants', 'contests.id', '=', 'contest_participants.contest_id')
            ->where('contest_participants.user_id', \auth()->user()->id)
            ->where('end', '>', Carbon::today()->format('Y-m-d'))
            ->get()
            ->map(function ($group) {
            return [
                'contest_id' => $group->id,
                'contest_name' => $group->title,
                'contest_first_prize' => $group->prize_first,
                'contest_second_prize' => $group->prize_second,
                'contest_third_prize' => $group->prize_third,
                'start' => Carbon::parse($group->start)->format('jS F Y'),
                'end' => Carbon::parse($group->end)->format('jS F Y'),
                'rules' => $group->rules,
            ];
        });
    }

    public function getWinners($month = '', $year = '', $today = '')
    {
        if($month == '') {
            $month = Carbon::now()->month;
        }
        if($year == '') {
            $year = Carbon::now()->year;
        }

        return DB::table('contest_voting_results')
            ->leftJoin('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->leftJoin('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
            ->leftJoin('portfolios', 'portfolios.user_id', 'users.id')
            ->leftJoin('configures', 'configures.user_id', 'users.id')
            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'contests.end as end', 'users.name as user_name', 'users.id as uid', 'users.username as username',
                DB::raw('SUM(vote_count) as total_votes'), 'portfolios.file_name', 'portfolios.ext', 'contests.prize_first', 'contests.prize_second', 'contests.prize_third', 'configures.key as config_key', 'configures.value as config_val')
            ->whereMonth("contests.start", $month)
            ->whereYear('contests.start', $year)
            ->where('portfolios.profile_photo', 1)
            ->where('contests.end', '<', Carbon::now()->format('Y-m-d'))
            ->groupBy('contest_id', 'whom_vote')
            ->orderByDesc('contest_id')
            ->orderByDesc('total_votes')
            ->get()
            ->groupBy('contest_id')
            ->take(10)
            ->map(function ($group) {
                return [
                    'contest_id' => $group->first()->contest_id,
                    'contest_name' => $group->first()->contest_name,
                    'first_prize' => $group->first()->prize_first,
                    'second_prize' => $group->first()->prize_second,
                    'third_prize' => $group->first()->prize_third,
                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
                    'end' => Carbon::parse($group->first()->end)->format('jS F Y'),
                    'winners' => $group->take(3)->map(function ($item) {
                        return [
                            'user_id' => $item->uid,
                            'username' => $item->username,
                            'user_name' => $item->user_name,
                            'user_bank' => $item->config_key == 'bank' ? $item->config_val : 'xxxxxxxxx',
                            'user_image' => [
                                'image_path' => $item->file_name . '.' . $item->ext,
                            ],
                            'total_votes' => $item->total_votes,
                        ];
                    })
                ];
            });
    }

    public function my_results()
    {
        $authUserId = auth()->id();

        return DB::table('contests')
            ->leftJoin('contest_voting_results', function ($join) use ($authUserId) {
                $join->on('contests.id', '=', 'contest_voting_results.contest_id')
                    ->where('contest_voting_results.whom_vote', '=', $authUserId);
            })
            ->leftJoin('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->leftJoin('portfolios', function ($join) {
                $join->on('portfolios.user_id', '=', 'users.id')
                    ->where('portfolios.profile_photo', 1);
            })
            ->leftJoin('contest_participants', function ($join) use ($authUserId) {
                $join->on('contest_participants.contest_id', '=', 'contests.id')
                    ->where('contest_participants.user_id', '=', $authUserId);
            })
            ->select(
                'contests.id as contest_id',
                'contests.title as contest_name',
                'contests.start as start',
                'contests.end as end',
                'users.name as user_name',
                'users.id as userId',
                'users.username as username',
                DB::raw('SUM(vote_count) as total_votes'),
                'portfolios.file_name',
                'portfolios.ext',
                DB::raw('IF(contest_participants.user_id = '.$authUserId.', true, false) as is_participant')
            )
            ->groupBy('contest_id', 'whom_vote')
            ->orderBy('contest_id')
            ->orderByDesc('total_votes')
            ->where('contest_participants.user_id', '=', $authUserId)
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                $winners = $group->take(3)->map(function ($item) {
                    return [
                        'userId' => $item->userId,
                        'username' => $item->username,
                        'user_name' => $item->user_name,
                        'user_image' => [
                            'image_path' => $item->file_name . '.' . $item->ext,
                        ],
                        'total_votes' => $item->total_votes,
                    ];
                });

                $isWinner = false;
                foreach ($winners as $winner) {
                    if ($winner['username'] == \auth()->user()->username) {
                        $isWinner = true;
                        break;
                    }
                }

                return [
                    'contest_id' => $group->first()->contest_id,
                    'contest_name' => $group->first()->contest_name,
                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
                    'end' => Carbon::parse($group->first()->end)->format('jS F Y'),
                    'winners' => $winners,
                    'winner' => $isWinner && $group->first()->end < Carbon::today()->format('Y-m-d') ? 'Won' : '',
                    'is_participant' => $group->first()->is_participant
                ];
            });

    }

    public function contestStats(int $contestId)
    {
        $results = DB::table('contest_voting_results')
            ->join('users', 'contest_voting_results.whom_vote', '=', 'users.id')
            ->select('contest_id', 'contest_voting_results.whom_vote as user_id', 'users.name as user_name', DB::raw('SUM(vote_count) as total_votes'))
            ->where('contest_id', $contestId)
            ->groupBy('contest_id', 'contest_voting_results.whom_vote')
            ->get();

        $all_participants = DB::table('contest_participants')
            ->join('users', 'users.id', '=', 'contest_participants.user_id')
            ->leftJoin('portfolios', function ($join) {
                $join->on('portfolios.user_id', '=', 'users.id')
                    ->whereRaw('portfolios.id = (select id from portfolios p2 where p2.profile_photo = 1 and p2.user_id = portfolios.user_id limit 1)');
            })
            ->where('contest_participants.contest_id', $contestId)
            ->get();

        return $all_participants->map(function ($participant) use ($results) {
            $user_votes = $results->where('user_id', $participant->user_id)->first();
            if ($user_votes) {
                return [
                    'user_id' => $participant->user_id,
                    'user_name' => $participant->name,
                    'user_image' => $participant->file_name . '.'. $participant->ext,
                    'total_votes' => $user_votes->total_votes
                ];
            } else {
                return [
                    'user_id' => $participant->user_id,
                    'user_name' => $participant->name,
                    'user_image' => $participant->file_name . '.'. $participant->ext,
                    'total_votes' => 0
                ];
            }
        })->groupBy('contest_id')->map(function ($participants, $contest_id) {
            $participants = $participants->sortByDesc('total_votes');
            return [
                'contest_id' => $contest_id,
                'participants' => $participants->toArray()
            ];
        })->values()->toArray();
    }

    public function getAdminModelConfigData($uid): array
    {
        $contestWon = DB::table('contest_voting_results')
            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->join('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
            ->select('contest_id')
            ->where('users.id', $uid)
            ->where('contest_voting_results.vote_count', '>', 0)
            ->where('contests.end', '<', Carbon::today()->format('Y-m-d'))
            ->groupBy('contest_id')
            ->havingRaw('SUM(vote_count) > 0')
            ->distinct()
            ->count();

        $participatedContests = DB::table('contest_voting_results')
            ->join('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->where('users.id', $uid)
            ->where('contest_voting_results.vote_count', '>', 0)
            ->select('contest_id')
            ->distinct()
            ->count();

        $userInfo = User::whereId($uid)
            ->select('created_at')
            ->first();

        return [
            'contest_won' => $contestWon,
            'contest_total' => $participatedContests,
            'user_registration' => $userInfo->created_at,
        ];
    }

    public function contestStats_backup($cateId, $month = '', $year = '')
    {
//        if($month == '') {
//            $month = Carbon::now()->month;
//        }
//        if($year == '') {
//            $year = Carbon::now()->year;
//        }
//
//        return DB::table('contest_voting_results')
//            ->leftJoin('users', 'users.id', '=', 'contest_voting_results.whom_vote')
//            ->leftJoin('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
//            ->leftJoin('portfolios', 'portfolios.user_id', 'users.id')
//            ->leftJoin('configures', 'configures.user_id', 'users.id')
//            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'users.name as user_name', 'users.username as username',
//                DB::raw('SUM(vote_count) as total_votes'), 'portfolios.file_name', 'portfolios.ext', 'contests.prize_first', 'contests.prize_second', 'contests.prize_third')
//            ->where('contests.category_id', $cateId)
//            ->whereMonth("contests.start", $month)
//            ->whereYear('contests.start', $year)
//            ->groupBy('contest_id', 'whom_vote')
//            ->distinct()
//            ->orderByDesc('contest_id')
//            ->get()
//            ->groupBy('contest_id')
//            ->map(function ($group) {
//                return [
//                    'contest_id' => $group->first()->contest_id,
//                    'contest_name' => $group->first()->contest_name,
//                    'first_prize' => $group->first()->prize_first,
//                    'second_prize' => $group->first()->prize_second,
//                    'third_prize' => $group->first()->prize_third,
//                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
//                    'participants' => $group->map(function ($item) {
//                        return [
//                            'username' => $item->username,
//                            'user_name' => $item->user_name,
//                            'user_image' => [
//                                'image_path' => $item->file_name . '.' . $item->ext,
//                            ],
//                            'total_votes' => $item->total_votes,
//                        ];
//                    })
//                ];
//            });
    }

    public function getWinnersJob()
    {
        return DB::table('contest_voting_results')
            ->leftJoin('users', 'users.id', '=', 'contest_voting_results.whom_vote')
            ->leftJoin('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
            ->leftJoin('portfolios', 'portfolios.user_id', 'users.id')
            ->leftJoin('configures', 'configures.user_id', 'users.id')
            ->select('contest_voting_results.contest_id', 'contests.title as contest_name', 'contests.start as start', 'contests.end as end', 'users.name as user_name', 'users.email as user_email', 'users.id as uid', 'users.username as username',
                DB::raw('SUM(vote_count) as total_votes'), 'portfolios.file_name', 'portfolios.ext', 'contests.prize_first', 'contests.prize_second', 'contests.prize_third', 'configures.key as config_key', 'configures.value as config_val')
            ->where('portfolios.profile_photo', 1)
            ->where('contests.end', '=', Carbon::now()->subDay()->format('Y-m-d'))
            ->where('contests.end', '<', Carbon::now()->format('Y-m-d'))
            ->groupBy('contest_id', 'whom_vote')
            ->orderByDesc('contest_id')
            ->orderByDesc('total_votes')
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                return [
                    'contest_id' => $group->first()->contest_id,
                    'contest_name' => $group->first()->contest_name,
                    'first_prize' => $group->first()->prize_first,
                    'second_prize' => $group->first()->prize_second,
                    'third_prize' => $group->first()->prize_third,
                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
                    'end' => Carbon::parse($group->first()->end)->format('jS F Y'),
                    'winners' => $group->take(3)->map(function ($item) {
                        return [
                            'user_id' => $item->uid,
                            'username' => $item->username,
                            'user_name' => $item->user_name,
                            'user_email' => $item->user_email,
                            'user_bank' => $item->config_key == 'bank' ? $item->config_val : 'xxxxxxxxx',
                            'user_image' => [
                                'image_path' => $item->file_name . '.' . $item->ext,
                            ],
                            'total_votes' => $item->total_votes,
                        ];
                    })
                ];
            });
    }


}
