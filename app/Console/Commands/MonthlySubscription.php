<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\ModelsService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Command;

class MonthlySubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'We will charge each customer every month.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ModelsService $modelsService)
    {
        User::whereHas('payment', function($query) {
            $query->where('end_date', '<', now());
        })
            ->select('id', 'name', 'payment_card_id', 'email', 'tax_id')
            ->chunk(50, function ($users) use ($modelsService) {
                foreach ($users as $user) {
                    $charge = [];
                    //checking payment_card_id if null, we need to update their subscribed column
                    if ($user->payment_card_id === null || $user->payment_card_id === '') {
                        User::where('id', $user->id)->update(['subscribed' => 0]); //cancel subscription.
                        \App\Models\Payment::whereUserId($user->id)->delete();
                    } else {
                        //call charge method
                        $customerInfo = [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'tax_id' => $user->tax_id,
                        ];
                        $modelsService->chargeMonthly($user->payment_card_id, 19, $customerInfo);
                    }
                }
            });
    }
}
