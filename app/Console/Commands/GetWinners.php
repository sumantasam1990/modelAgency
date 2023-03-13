<?php

namespace App\Console\Commands;

use App\Models\Winner;
use App\Services\ContestService;
use Illuminate\Console\Command;

class GetWinners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:winners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'After expired contest getting last 3 winners.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ContestService $contestService)
    {
        $data = $contestService->getWinnersCommand();

        foreach ($data as $da)
        {
            foreach ($da['winners'] as $d)
            {
                $winnerChk = Winner::where('contest_id', $da['contest_id'])
                    ->where('user_id', $d['user_id'])
                    ->select('id')
                    ->get();
                if (count($winnerChk) === 0)
                {
                    $winner = new Winner;
                    $winner->contest_id = $da['contest_id'];
                    $winner->user_id = $d['user_id'];
                    $winner->total_votes = (int)$d['total_votes'];
                    $winner->rank = (int)$d['rank'];
                    $winner->save();
                }
            }
        }
        return null;
    }
}
