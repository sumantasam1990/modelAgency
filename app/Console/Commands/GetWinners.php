<?php

namespace App\Console\Commands;

use App\Mail\SendWinnersEmail;
use App\Models\ContestParticipants;
use App\Models\Payment;
use App\Models\portfolio;
use App\Models\User;
use App\Models\Winner;
use App\Services\ContestService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
                    $photo = ContestParticipants::where('user_id', $d['user_id'])
                        ->where('contest_id', $da['contest_id'])
                        ->select('id', 'contest_photo')
                        ->get();

                    if(count($photo) > 0) {
                        if ($photo[0]->contest_photo != null) {
                            $contest_photo = $photo[0]->contest_photo;
                        } else {
                            $portfolio = portfolio::where('user_id', $d['user_id'])
                                ->select('id', 'file_name', 'ext')
                                ->where('contest_photo', 1)
                                ->get();

                            if (count($portfolio) > 0) {
                                $contest_photo = $portfolio[0]->file_name . '.' . $portfolio[0]->ext;
                            }
                        }
                    }

                    $winner = new Winner;
                    $winner->contest_id = $da['contest_id'];
                    $winner->user_id = $d['user_id'];
                    $winner->total_votes = (int)$d['total_votes'];
                    $winner->rank = (int)$d['rank'];
                    $winner->winner_photo = $contest_photo ?? null;
                    $winner->save();

                    if($d['rank'] > 0 && $d['rank'] < 4)
                    {
                        // send winner an email
                        $array_data = [
                            'contest_name' => $da['contest_name'],
                            'end' => $da['end'],
                            'index' => (int)$d['rank'],
                        ];
                        if ($d['total_votes'] > 0) {
                            //getting subscription
                            Payment::where('user_id', $d['user_id'])->delete();
                            $payment = new Payment;
                            $payment->user_id = $d['user_id'];
                            $payment->amount = 0.00;
                            $payment->start_date = Carbon::today()->format('Y-m-d');
                            if ($d['rank'] == 1) {
                                $payment->end_date = Carbon::now()->addDays($da['prize_first'])->format('Y-m-d');
                            }
                            elseif ($d['rank'] == 2) {
                                $payment->end_date = Carbon::now()->addDays($da['prize_second'])->format('Y-m-d');
                            }
                            elseif ($d['rank'] == 3) {
                                $payment->end_date = Carbon::now()->addDays($da['prize_third'])->format('Y-m-d');
                            }
                            else {
                                // nothing to do...
                            }

                            $payment->transaction_id = "free_prize_sub";
                            $payment->save();

                            User::where('id', $d['user_id'])->update(['subscribed' => 1, 'payment_card_id' => 'free_prize']);

                            Mail::to($d['user_email'])->queue(new SendWinnersEmail($array_data));
                        }
                    }
                }
            }
        }
        return null;
    }
}
