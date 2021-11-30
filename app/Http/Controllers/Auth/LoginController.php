<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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

    public function login(Request $request)
    {
        $request->validate([
			'username' => ['required'],
			'password' => ['required'],
		]);
        // $credentials = $request->only('username', 'password');
        $username = $request->get('username');
        $password = $request->get('password'); 

        if (Auth::attempt(['username' => $username, 'password' => $password, 'is_verified' => 1])) {
            /* if(Auth::user()->roles()->where('id', 3)->exists()){
                return redirect()->route('home');
            }
            elseif(Auth::user()->roles()->where('id', 1)->exists()){
                if($request->ajax()){
                    return response()->json([
                        'redirect' => route('admin.home')
                    ]);
                }else{
                    return redirect()->route('admin.home');
                }
            } */
            if(Auth::user()->hasrole('System Administrator') || Auth::user()->hasrole('Administrator')){
                return redirect()->route('home');
            }elseif(Auth::user()->hasrole('Faculty') || Auth::user()->hasrole('Student')){
                return redirect()->route('evaluations.index');
            }
        }else{
            $user = User::where([
                ['is_verified', '=', 0],
                ['username', '=', $username],
                // ['password', '=', $password],
            ])->exists();
            $message = "These credentials do not match our records.";
            if($user){
                $message = "Your account is under validation.";
            }
            return redirect()->route('login')
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => $message]);
            // return back()->with('alert-danger', 'User not found');
        }
    }
}
