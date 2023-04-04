<?php

namespace App\Console\Commands;

use App\Mail\SendWinnersEmail;
use App\Models\Winner;
use App\Services\ContestService;
use Illuminate\Console\Command;
use Mail;

class WinnersSendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendemailtowinners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ContestService $contestService)
    {
        $data = $contestService->getWinnersJob();

        foreach ($data as $d)
        {
            $i = 1;
            foreach ($d['winners'] as $winner) {
                if($i === 1) {
                    $index = '1st';
                } elseif ($i === 2) {
                    $index = '2nd';
                } else {
                    $index = '3rd';
                }
                $array_data = [
                    'contest_name' => $d['contest_name'],
                    'end' => $d['end'],
                    'index' => $index,
                ];
                Mail::to($winner['user_email'])->queue(new SendWinnersEmail($array_data));
                $i++;
            }
        }

        return Command::SUCCESS;
    }
}
