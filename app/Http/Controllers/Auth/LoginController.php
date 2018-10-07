<?php

namespace App\Http\Controllers\Auth;

use App\Entity\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
Use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $authenticate = Auth::attempt(
            $request->only('email', 'password'),
            $request->filled('remember_token')
        );
        
        if ($authenticate) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);

            $user = Auth::user();
            if ($user->status !== User::STATUS_ACTIVE) {
                Auth::logout();
                return back()->with('error', 'You need to confirm your account. Please check your email.');
            }

            redirect()->intended(route('cabinet'));
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);

    }


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(LoginRequest $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('home');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}
