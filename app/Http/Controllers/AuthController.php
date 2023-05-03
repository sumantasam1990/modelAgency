<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect(route('edit.profile'));
        }
        $arr = [1,2,3,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48,50,52,54,56,58,60,62,64,66,68,70];

        return view('auth.login', compact('arr'));
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Cache::clear();

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            if($request->email == 'admin@admin.com')
            {
                return redirect()->intended('admin/stats');
            }
            else
            {
                if (Auth::user()->subscribed === 1) {
                    return redirect()->intended('model/contests/vote');
                } else {
                    return redirect()->intended('model/subscription/now');
                }

            }

        }
        return back()->with([
            'err' => 'As informações estão incorretas. Tente novamente.',
        ]);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_post(Request $request)
    {
        try {
            $request->validate([
                '_name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'min:8',
//                'state' => 'required',
//                'city' => 'required',
//                '_district' => 'required',
//                '_wp' => 'required',
//                '_gender' => 'required',
//                '_civil_status' => 'required',
//                '_age' => 'required',
//                'dress' => 'required',
//                '_height' => 'required',
            ]);

            $data = $request->all();
            $user = $this->create($data);
            event(new Registered($user));

        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return redirect(route('login'))->with('msg', '<p>Nós te enviamos um e-mail de verificação. </p> <p>Confirme seu e-mail para poder acessar sua conta eumodelo.</p><p> Se o email não chegou, verifique sua caixa de spam.</p>');
    }

    private function create(array $data)
    {
        $user = User::create([
            'name' => $data['_name'] ?? '',
            'email' => $data['email'] ?? '',
//            'state' => $data['state'] ?? '',
//            'city' => implode(',', $data['city']) ?? '',
//            'district' => $data['_district'] ?? '',
//            'wp' => $data['_wp'] ?? '',
//            'gender' => $data['_gender'],
//            'civil' => $data['_civil_status'],
            'password' => Hash::make($data['password']),
            'username' => $data['_name'].User::where('name', '=', $data['_name'])->count('id'),

//            'age' => $data['_age'],
//            'bust' => $data['bust'],
//            'eyes' => $data['eyes'],
//            'hips' => $data['hips'],
//            'skin' => $data['_skin'],
//            'dress' => $data['dress'],
//            'other' => implode(',', $data['other']) ?? '',
//            'waist' => $data['waist'],
//            'height' => $data['_height'],
//            'hair' => $data['hair'],
        ]);

        // get free trial for 10 days
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->amount = 0.00;
        $payment->start_date = Carbon::today()->format('Y-m-d');
        $payment->end_date = Carbon::now()->addDays(10)->format('Y-m-d');
        $payment->transaction_id = "free_trial_10_days";
        $payment->save();

        User::where('id', $user->id)
            ->update(['subscribed' => 1, 'payment_card_id' => 'free_trial']);

        return $user;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cache::clear();
        return redirect(route('login'));
    }
}
