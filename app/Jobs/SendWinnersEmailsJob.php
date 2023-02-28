<?php

namespace App\Jobs;

use App\Mail\SendWinnersEmail;
use App\Models\User;
use App\Services\ContestService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWinnersEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ContestService $contestService)
    {
        $data = $contestService->getWinnersJob();
        $array_data = [];
        Mail::to("sumantasam1990@gmail.com")->send(new SendWinnersEmail($array_data));
//        foreach ($data as $d)
//        {
//            $i = 1;
//            foreach ($d['winners'] as $winner) {
//                $array_data = [
//                    'contest_name' => $d['contest_name'],
//                    'end' => $d['end'],
//                    'index' => $i,
//                ];
//                Mail::to("sumantasam1990@gmail.com")->queue(new SendWinnersEmail($array_data));
//                $i++;
//            }
//        }
    }
}
