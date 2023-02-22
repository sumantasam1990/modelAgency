<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function help()
    {
        $data = Faq::all();

        return view('help.index', compact('data'));
    }
}
