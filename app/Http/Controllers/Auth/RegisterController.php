<?php

namespace App\Http\Controllers\Auth;

use App\Mail\Auth\VerifyMail;
use App\Entity\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Str;
use App\UseCases\Auth\RegisterService;

class RegisterController extends Controller
{
    private $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }


    public function register(RegisterRequest $request)
    {
        $this->service->register($request);

        return redirect()->route('login')
            ->with('success', 'Your email is verified. You can now login.');
    }


    public function verify($token)
    {
        if (!$user = User::where('verify_token', $token)->first()) {
            return redirect()->route('login')
                ->with('error', 'Sorry your link cannot be identified.');
        }

        try{
            $this->service->verify($user->id);
            return redirect()->route('login')->with('success', 'Your email is verified. You can now login.');
        }catch (\DomainException $e){
            return redirect()->route('login')->with('error', $e->getMessage());
        }
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

        return redirect()->route('cabinet');
    }

    protected function registered()
    {
        $this->guard()->logout();

        return redirect()->route('login')
                    ->with('success', 'Проверьте ваш емайл');
    }
}
