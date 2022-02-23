<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\LoginInfo;
use Jenssegers\Agent\Agent;
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
        
        $client = new Agent();
        $loginInfo = LoginInfo::create([
            'username' => $request->username,
            'activity' => 'login',
            'ip_address' => $request->ip(),
            'device' => $client->device(),
            'platform' => $client->platform(),
            'browser' => $client->browser(),
        ]);

        if (Auth::attempt(['username' => $username, 'password' => $password, 'is_verified' => 1])) {
            if(isset(Auth::user()->student->id)){
                $student = Student::withTrashed()->find(Auth::user()->student->student_id);
                if($student->trashed()){
                    $loginInfo->update([
                        'status' => 'Failed'
                    ]);
                    Auth::logout();
                    return redirect()->route('login')
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors(['username' => 'These credentials do not match our records.']);
                }
            }else{
                $faculty = Faculty::withTrashed()->find(Auth::user()->faculty->faculty_id);
                if($faculty->trashed()){
                    $loginInfo->update([
                        'status' => 'Failed'
                    ]);
                    Auth::logout();
                    return redirect()->route('login')
                    ->withInput($request->only('username', 'remember'))
                    ->withErrors(['username' => 'These credentials do not match our records.']);
                }
            }
            $loginInfo->update([
                'user_id' => Auth::user()->id,
                'status' => 'Success',
            ]);
            return redirect()->route('evaluations.index');
        }else{
            $user = User::where([
                ['is_verified', '=', 0],
                ['username', '=', $username],
                // ['password', '=', $password],
            ])->exists();
            $loginInfo->update([
                'status' => 'Failed'
            ]);
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
