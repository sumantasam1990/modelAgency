<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function Notification($information)
    {
        //\Log::debug(print_r($information->getStatus()->getCode(), 1));
    }

    public function cancel_membership(): RedirectResponse
    {
        User::whereId(Auth::user()->id)
            ->update(['payment_card_id' => null]);

        return redirect()->back()->with('msg', 'Your membership has been cancelled.');
    }
}
