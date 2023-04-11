<?php

namespace App\Services;

use App\Models\BankTransfer;
use App\Models\Category;
use App\Models\Contest;
use App\Models\ContestParticipants;
use App\Models\ContestVotingResult;
use App\Models\User;
use App\Models\Winner;
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
            $users->whereBetween('users->_age', [$request['age_from'], $request['age_to']]);
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
//            ->where('status', 0)
            ->whereBetween('created_at', [$from, $to]);

        return $this->extracted($users, $request);
    }

    public function totalSubscribers(String $from, String $to, $request): int
    {
        $users = User::where('email', '!=', 'admin@admin.com')
            ->where('subscribed', 1)
            ->whereHas('payment', function ($q) use ($from, $to) {
                $q->whereBetween('start_date', [$from, $to]);
            });

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
        return Contest::with('users_for_vote.portfolio')
            ->whereNotIn('id', $getAlreadyVotedUsers)
            ->whereNotIn('id', $contestParticipants)
            ->where('end', '>=', Carbon::today()->format('Y-m-d'))
            ->where('start', '<=', Carbon::today()->format('Y-m-d') )
            ->whereMonth('start', Carbon::now()->month)
//            ->whereHas('users', function ($query) {
//                $query->where('status', 1);
//                $query->where('subscribed', 1);
//            })
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
            ->where('end', '>=', Carbon::today()->format('Y-m-d'))
            ->select('contests.id as contest_id', 'contests.title as title', 'contests.prize_first', 'contests.prize_second', 'contests.prize_third', 'contests.start', 'contests.end', 'contests.rules', 'contest_participants.contest_photo')
            ->get()
            ->map(function ($group) {
            return [
                'contest_id' => $group->contest_id,
                'contest_name' => $group->title,
                'contest_first_prize' => $group->prize_first,
                'contest_second_prize' => $group->prize_second,
                'contest_third_prize' => $group->prize_third,
                'start' => $group->start,
                'end' => $group->end,
                'rules' => $group->rules,
                'contest_photo' => $group->contest_photo,
            ];
        });
    }

    public function winners($month = '', $year = '', $today = '')
    {
        if($month == '') {
            $month = Carbon::now()->month;
        }
        if($year == '') {
            $year = Carbon::now()->year;
        }

        return DB::table('winners')
            ->join('contests', 'winners.contest_id', '=', 'contests.id')
            ->join('users', 'winners.user_id', '=', 'users.id')
            ->join('portfolios', function ($join) {
                $join->on('users.id', '=', 'portfolios.user_id')
                    ->where('portfolios.profile_photo', '=', 1)
                    ->limit(1);
            })
            ->select('contests.id as contest_id', 'contests.title as contest_name', 'contests.start', 'contests.end', 'contests.prize_first', 'contests.prize_second', 'contests.prize_third', 'winners.user_id as uid', 'users.name as user_name', 'users.username as username', 'winners.total_votes as total_votes', 'portfolios.file_name', 'portfolios.ext', 'winners.winner_photo', 'winners.rank as rank')
            ->whereMonth("contests.start", $month)
            ->whereYear('contests.start', $year)
            ->where('winners.rank', '>', 0)
            ->where('winners.rank', '<', 4)
            ->where('total_votes', '>', 0)
            ->where('contests.end', '<', Carbon::now()->format('Y-m-d'))
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                return [
                    'contest_id' => $group[0]->contest_id,
                    'contest_name' => $group[0]->contest_name,
                    'first_prize' => $group[0]->prize_first,
                    'second_prize' => $group[0]->prize_second,
                    'third_prize' => $group[0]->prize_third,
                    'start' => Carbon::parse($group[0]->start)->isoFormat('Do [de] MMMM [de] YYYY'),
                    'end' => Carbon::parse($group[0]->end)->isoFormat('Do [de] MMMM [de] YYYY'),
                    'winners' => $group->map(function ($item) {
                        return [
                            'user_id' => $item->uid,
                            'user_name' => $item->user_name,
                            'username' => $item->username,
                            'user_image' => [
                                'image_path' => $item->winner_photo,
                            ],
                            'total_votes' => $item->total_votes,
                            'rank' => $item->rank,
                        ];
                    })
                        ->sortBy('rank') // Order by ascending rank
                        ->toArray(),
                ];
            })
            ->values()
            ->toArray();
    }

    public function getWinners($month = '', $year = '', $today = '')
    {
        if($month == '') {
            $month = Carbon::now()->month;
        }
        if($year == '') {
            $year = Carbon::now()->year;
        }

        return DB::table('contests')
            ->join('winners', 'winners.contest_id', '=', 'contests.id')
            ->join('users', 'winners.user_id', '=', 'users.id')
            ->join('portfolios', function ($join) {
                $join->on('users.id', '=', 'portfolios.user_id')
                    ->where('portfolios.profile_photo', '=', 1)
                    ->limit(1);
            })
            ->leftJoin('bank_transfers', function ($join) {
                $join->on('bank_transfers.user_id', '=', 'winners.user_id')
                    ->on('bank_transfers.contest_id', '=', 'contests.id');
            })
            ->leftJoin('configures', function ($join) {
                $join->on('configures.user_id', '=', 'winners.user_id')
                    ->whereIn('configures.key', ['bank', 'pix']);
            })
            ->select(
                'contests.id as contest_id', 'contests.title as contest_name', 'start', 'end', 'prize_first', 'prize_second', 'prize_third', 'winners.user_id as uid', 'users.name as user_name', 'username as username', 'winners.total_votes as total_votes', 'portfolios.file_name', 'portfolios.ext', 'winners.rank as rank', 'bank_transfers.acc_no as acc_no',
                DB::raw('GROUP_CONCAT(IF(configures.key = "bank", configures.value, NULL)) as bank'),
                DB::raw('GROUP_CONCAT(IF(configures.key = "pix", configures.value, NULL)) as pix'),
                'users.wp as wp'
            )
            ->whereMonth("contests.start", $month)
            ->whereYear('contests.start', $year)
            ->where('contests.end', '<', Carbon::now()->format('Y-m-d'))
            ->where('total_votes', '>', 0)
            ->where('rank', '>', 0)
            ->where('rank', '<', 4)
            ->orderByDesc('contest_id')
            ->orderBy('rank')
            ->groupBy('contest_id', 'uid')
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                return [
                    'contest_id' => $group[0]->contest_id,
                    'contest_name' => $group[0]->contest_name,
                    'first_prize' => $group->first()->prize_first,
                    'second_prize' => $group->first()->prize_second,
                    'third_prize' => $group->first()->prize_third,
                    'start' => Carbon::parse($group->first()->start)->isoFormat('Do [de] MMMM [de] YYYY'),
                    'end' => Carbon::parse($group->first()->end)->isoFormat('Do [de] MMMM [de] YYYY'),
                    'winners' => $group->map(function ($item) {
                        $accMatch = isset($item->acc_no) && ($item->acc_no == $item->bank || $item->acc_no == $item->pix) ? 0 : 1;
                        return [
                            'user_id' => $item->uid,
                            'user_name' => $item->user_name,
                            'username' => $item->username,
                            'user_image' => [
                                'image_path' => $item->file_name . '.' . $item->ext,
                            ],
                            'total_votes' => $item->total_votes,
                            'rank' => $item->rank,
                            'user_bank' => $item->bank ?? 'xxxxxxxxx',
                            'user_pix' => $item->pix ?? 'xxxxxxxxx',
                            'accMatch' => $accMatch,
                            'wp' => $item->wp,
                        ];
                    })->toArray(),
                ];
            })
            ->values()
            ->toArray();




//        return DB::table('contest_voting_results')
//            ->leftJoin('users', 'users.id', '=', 'contest_voting_results.whom_vote')
//            ->leftJoin('contests', 'contests.id', '=', 'contest_voting_results.contest_id')
//            ->leftJoin('portfolios', 'portfolios.user_id', 'users.id')
//            ->leftJoin('configures', function($join) {
//                $join->on('configures.user_id', '=', 'users.id');
//            })
//            ->select(
//                'contest_voting_results.contest_id',
//                'contests.title as contest_name',
//                'contests.start as start',
//                'contests.end as end',
//                'users.name as user_name',
//                'users.id as uid',
//                'users.username as username',
//                DB::raw('SUM(vote_count) as total_votes'),
//                'portfolios.file_name',
//                'portfolios.ext',
//                'contests.prize_first',
//                'contests.prize_second',
//                'contests.prize_third',
//                DB::raw("MAX(CASE WHEN configures.key = 'bank' THEN configures.value ELSE NULL END) AS bank"),
//                DB::raw("MAX(CASE WHEN configures.key = 'pix' THEN configures.value ELSE NULL END) AS pix")
//            )
//            ->whereMonth("contests.start", $month)
//            ->whereYear('contests.start', $year)
//            ->where('portfolios.profile_photo', 1)
//            ->where('contests.end', '<', Carbon::now()->format('Y-m-d'))
//            ->groupBy('contest_id', 'whom_vote', 'users.id')
//            ->orderByDesc('contest_id')
//            ->orderByDesc('total_votes')
//            ->get()
//            ->groupBy('contest_id')
//            //->take(10)
//            ->map(function ($group) {
//                return [
//                    'contest_id' => $group->first()->contest_id,
//                    'contest_name' => $group->first()->contest_name,
//                    'first_prize' => $group->first()->prize_first,
//                    'second_prize' => $group->first()->prize_second,
//                    'third_prize' => $group->first()->prize_third,
//                    'start' => Carbon::parse($group->first()->start)->format('jS F Y'),
//                    'end' => Carbon::parse($group->first()->end)->format('jS F Y'),
//                    'winners' => $group->take(3)->map(function ($item) {
//                        return [
//                            'user_id' => $item->uid,
//                            'username' => $item->username,
//                            'user_name' => $item->user_name,
//                            'user_bank' => $item->bank ?? 'xxxxxxxxx',
//                            'user_pix' => $item->pix ?? 'xxxxxxxxx',
//                            'user_image' => [
//                                'image_path' => $item->file_name . '.' . $item->ext,
//                            ],
//                            'total_votes' => $item->total_votes,
//                        ];
//                    }),
//                ];
//            });
    }

    public function getWinnersCommand($month = '', $year = '', $today = '')
    {
        if($month == '') {
            $month = Carbon::now()->month;
        }
        if($year == '') {
            $year = Carbon::now()->year;
        }

        return DB::table('contest_participants')
            ->leftJoin('contest_voting_results', function ($join) {
                $join->on('contest_participants.user_id', '=', 'contest_voting_results.whom_vote')
                    ->on('contest_participants.contest_id', '=', 'contest_voting_results.contest_id');
            })
            ->leftJoin('users', 'users.id', '=', 'contest_participants.user_id')
            ->leftJoin('contests', 'contests.id', '=', 'contest_participants.contest_id')
            ->leftJoin('portfolios', 'portfolios.user_id', '=', 'users.id')
            ->select(
                'contest_participants.contest_id',
                'contests.title as contest_name',
                'contests.start as start',
                'contests.end as end',
                'users.name as user_name',
                'users.id as uid',
                'users.username as username',
                'users.email as user_email',
                DB::raw('COALESCE(SUM(vote_count), 0) as total_votes'),
                'portfolios.file_name',
                'portfolios.ext',
                'contests.prize_first',
                'contests.prize_second',
                'contests.prize_third',
            )
            ->whereMonth("contests.start", $month)
            ->whereYear('contests.start', $year)
            ->where('portfolios.profile_photo', 1)
            ->where('contests.end', '<', Carbon::now()->format('Y-m-d'))
            ->groupBy('contest_participants.contest_id', 'contest_participants.user_id')
            ->orderByDesc('contest_participants.contest_id')
            ->orderByDesc('total_votes')
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                // Compute the maximum number of votes.
                $max_votes = $group->max('total_votes');

                // Find the IDs of the winners with the maximum number of votes.
                $winner_ids = $group->filter(function ($item) use ($max_votes) {
                    return $item->total_votes == $max_votes;
                })->pluck('uid');

                // Give an extra vote to the oldest winner if there is a tie.
                if (count($winner_ids) > 1) {
                    $oldest_winner = $group->filter(function ($item) use ($winner_ids) {
                        return $winner_ids->contains($item->uid);
                    })->sortBy('start')->first();

                    $oldest_winner->total_votes += 1;
                }

                return [
                    'contest_id' => $group->first()->contest_id,
                    'contest_name' => $group->first()->contest_name,
                    'end' => $group->first()->end,
                    'winners' => $group->map(function ($item, $index) {
                        return [
                            'user_id' => $item->uid,
                            'user_email' => $item->user_email,
                            'total_votes' => $item->total_votes,
                            'rank' => $index + 1,
                        ];
                    }),
                ];
            });

    }

    public function my_results()
    {
        $loggedInUserId = auth()->user()->id;

        return DB::table('contests')
            ->join('winners', 'winners.contest_id', '=', 'contests.id')
            ->join('users', 'winners.user_id', '=', 'users.id')
            ->join('portfolios', function ($join) {
                $join->on('users.id', '=', 'portfolios.user_id')
                    ->where('portfolios.profile_photo', '=', 1)
                    ->limit(1);
            })
            ->leftJoin('bank_transfers', function ($join) {
                $join->on('users.id', '=', 'bank_transfers.user_id')
                    ->on('contests.id', '=', 'bank_transfers.contest_id');
            })
            ->select('contests.id as contest_id', 'contests.title as contest_name', 'start', 'end', 'prize_first', 'prize_second', 'prize_third', 'winners.user_id as uid', 'users.name as user_name', 'username as username', 'winners.total_votes as total_votes', 'portfolios.file_name', 'portfolios.ext', 'bank_transfers.status as bank_status', 'winners.rank as rank')
            ->where('winners.user_id', $loggedInUserId)
            ->orderByDesc('contest_id')
            ->get()
            ->groupBy('contest_id')
            ->map(function ($group) {
                return [
                    'contest_id' => $group[0]->contest_id,
                    'contest_name' => $group[0]->contest_name,
                    'first_prize' => $group->first()->prize_first,
                    'second_prize' => $group->first()->prize_second,
                    'third_prize' => $group->first()->prize_third,
                    'start' => Carbon::parse($group->first()->start)->isoFormat('Do [de] MMMM [de] YYYY'),
                    'end' => Carbon::parse($group->first()->end)->isoFormat('Do [de] MMMM [de] YYYY'),
                    'bank_status' => $group->first()->bank_status,
                    'winners' => $group->map(function ($item) {
                        return [
                            'user_id' => $item->uid,
                            'user_name' => $item->user_name,
                            'username' => $item->username,
                            'user_image' => [
                                'image_path' => $item->file_name . '.' . $item->ext,
                            ],
                            'total_votes' => $item->total_votes,
                            'rank' => $item->rank,
                        ];
                    })->toArray(),
                ];
            })
            ->values()
            ->toArray();
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
                    'start' => Carbon::parse($group->first()->start)->isoFormat('Do [de] MMMM [de] YYYY'),
                    'end' => Carbon::parse($group->first()->end)->isoFormat('Do [de] MMMM [de] YYYY'),
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

    public function putUserIntoParticipants(int $userId)
    {
        //checking if subscribed or not
        $subscribeChk = User::where('subscribed', 1)->where('id', $userId)->count('id');
        if ($subscribeChk === 1) {
            $contests = Contest::with('category')
                ->where('end', '>', now())
                ->whereHas('category', function ($query) use ($userId) {
                    $userHeight = User::find($userId)->height;
                    $dateOfBirth = User::find($userId)->age;
                    $age = \Carbon\Carbon::parse($dateOfBirth)->diffInMonths(Carbon::now());
                    $gender = User::find($userId)->gender;


                    $query->whereRaw("FIND_IN_SET('$gender', _gender) > 0")
                        ->whereRaw("SUBSTRING_INDEX(_height, ',', 1) <= $userHeight")
                        ->whereRaw("SUBSTRING_INDEX(_height, ',', -1) >= $userHeight")
                        ->where(function ($q) use ($userId, $age) {
                            $q->where('_age', '=', null)
                                ->orWhere('_age', '=', ',')
                                ->orWhere('_age', '=', '')
                                ->orWhereRaw("SUBSTRING_INDEX(_age, ',', 1) <= " . intval($age))
                                ->whereRaw("SUBSTRING_INDEX(_age, ',', -1) >= " . intval($age));
                        })
                        ->where(function ($q) use ($userId) {
                            $q->where('_dress', '=', null)
                                ->orWhere('_dress', '=', '')
                                ->orWhereRaw("FIND_IN_SET('" . User::find($userId)->dress . "', _dress)");
                        });
                })
                ->get();

            $contest_ids = $contests->pluck('id');

            foreach ($contest_ids as $id)
            {
                $contestParticipant = ContestParticipants::whereContestId($id)
                    ->where('user_id', $userId)
                    ->count('id');
                if ($contestParticipant === 0)
                {
                    $participant = new ContestParticipants;
                    $participant->contest_id = $id;
                    $participant->user_id = $userId;
                    $participant->save();
                }
            }
        }
    }
}
