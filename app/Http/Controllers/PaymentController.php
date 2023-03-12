<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function Notification($information)
    {
        \Log::debug(print_r($information->getStatus()->getCode(), 1));
    }
}
