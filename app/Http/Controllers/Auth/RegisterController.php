<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Auth\VerifyMail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/cabinet';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array  $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verify_token' => Str::random(),
            'status' => User::STATUS_WAIT,
        ]);

        \Mail::to($user->email)->queue(new VerifyMail());

        return redirect()->route('home');
    }

    protected function registered()
    {
        $this->guard()->logout();

        return redirect()->route('login')
                    ->with('success', 'Проверьте ваш емайл');
    }
}
