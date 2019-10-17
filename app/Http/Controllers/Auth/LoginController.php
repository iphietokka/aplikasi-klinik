<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\User;
use Hash;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function credentials(Request $request)
    {
        return ['username' => $request->{$this->username()}, 'password' => $request->password, 'active' => 1];
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
        $user = User::where($this->username(), $request{
            $this->username()})->first();

        if ($user && Hash::check($request->password, $user->password) && $user->active != 1) {
            $errors = [$this->username() => trans('auth.notactivated')];
        }
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->isAdmin()) {
            $active_user = User::find($user->id);
            $active_user->last_login = Carbon::now()->toDateTimeString();
            $active_user->save();
            return redirect(route('admin-home'));
        } elseif ($user->isUser()) {
            $active_user = User::find($user->id);
            $active_user->last_login = Carbon::now()->toDateTimeString();
            $active_user->save();
            return redirect(route('user-home'));
        }
        abort(404);
    }
}
