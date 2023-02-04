<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function add_category()
    {
        return view('admin.add_category');
    }

    public function add_category_post(Request $request)
    {
        return User::with('portfolio')
            ->select('id')
            ->whereIn('gender', $request->gender)
            ->whereIn('civil', ['single'])
            ->get();
    }
}
