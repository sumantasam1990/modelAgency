<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended('model/portfolio');
        }
        return back()->with([
            'err' => 'The provided credentials do not match our records. Please try again.',
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_post(Request $request)
    {
        $request->validate([
            '_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            '_state' => 'required',
            '_city' => 'required',
            '_district' => 'required',
            '_wp' => 'required',
            '_gender' => 'required',
            '_civil_status' => 'required',
        ]);

        $data = $request->all();

        $this->create($data);

        //event(new Registered($user));

        return redirect(route('login'))->with('msg', '<p>Please confirm your email to complete the sign up process. </p> <p>We have emailed you a verification</p>');
    }

    private function create(array $data): void
    {
        User::create([
            'name' => $data['_name'],
            'email' => $data['email'],
            'state' => $data['_state'],
            'city' => $data['_city'],
            'district' => $data['_district'],
            'wp' => $data['_wp'],
            'gender' => $data['_gender'],
            'civil' => $data['_civil_status'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
