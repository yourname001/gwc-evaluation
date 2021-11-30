<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuration\RolePermission\Role;
use App\Models\Configuration\RolePermission\UserRole;
use App\Models\UserFaculty;
use App\Models\UserStudent;
use Carbon\Carbon;
use Auth;
use Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivatedMail;
use App\Mail\AccountDeactivatedMail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users.index', ['only' => ['index']]);
        $this->middleware('permission:users.create', ['only' => ['create','store']]);
        $this->middleware('permission:users.show', ['only' => ['show']]);
        $this->middleware('permission:users.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$users->withTrashed();
		}else{
			$users->where('id', '!=', '1');
		}
		
		$data = [
			'users' => $users->get()
		];
		return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$roles = $roles;
		}elseif(Auth::user()->hasrole('Administrator')){
			$roles->where('id', '!=', 1)->get();
		}else{
			$roles->whereNotIn('id', [1,2]);
        }

		$data = [
			'roles' => $roles->get(),
		];

		if(request()->ajax()){
			return response()->json([
				'modal_content' => view('users.create', $data)->render()
			]);
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'user_id' => ['required'],
			'username' => ['required', 'string', 'max:255', 'unique:users,username'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
        $password = base64_encode(time());
        if($request->get('type') == 'student') {
            $user = User::create([
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($pasword),
                'temp_password' => $password,
            ]);
            $user->assignRole(4);
            UserStudent::create([
                'user_id' => $user->id,
                'student_id' => $request->get('user_id')
            ]);
        }else{
            $user = User::create([
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($pasword),
                'temp_password' => $password,
            ]);
            $user->assignRole(3);
            UserFaculty::create([
                'user_id' => $user->id,
                'faculty_id' => $request->get('user_id')
            ]);
        }
		return back()->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        /* if(request()->ajax()){
            $data = [
                'user' => $user
            ];
            return response()->json([
                'modal_content' => view('users.show', $data)->render()
            ]);
        } */
        return view('users.show', compact('user'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$roles = $roles;
		}elseif(Auth::user()->hasrole('Administrator')){
			$roles->where('id', '!=', 1)->get();
		}else{
			$roles->whereNotIn('id', [1,2]);
        }

		$data = [
			'roles' => $roles->get(),
			'user' => $user,
		];

		if(request()->ajax()){
			return response()->json([
				'modal_content' => view('users.edit', $data)->render()
			]);
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
			'role' => ['required'],
			'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);

		if($request->filled('password')){
			$request->validate([
				'password' => ['required', 'string', 'min:8', 'confirmed']
			]);
			$data = ([
				'username' => $request->get('username'),
				'email' => $request->get('email'),
				'password' => Hash::make($request->get('password')),
			]);
		}else{
			$data = ([
				'username' => $request->get('username'),
				'email' => $request->get('email'),
			]);
		}
		$user->update($data);
        
        $user->assignRole($request->role);
        
        /* if($request->get('type') == 'student') {
            UserStudent::create([
                'user_id' => $user->id,
                'student_id' => $request->get('user_id')
            ]);
        }else{
            UserFaculty::create([
                'user_id' => $user->id,
                'faculty_id' => $request->get('user_id')
            ]);
        } */
		return redirect()->route('users.show', $user->id)->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
	{
        if($user->id != 1){
            if (request()->get('permanent')) {
                $user->forceDelete();
            }else{
                $user->delete();
            }
            return redirect()->route('users.index')->with('alert-danger','Deleted');
        }else{
            return redirect()->route('users.index')->with('alert-danger','You cannot delete System Administrator');
        }
	}

	public function restore($user)
	{
		$user = User::withTrashed()->find($user);
		$user->restore();
		return redirect()->route('users.index')->with('alert-success','Restored');
    }
    
    public function activate(User $user)
    {
        $password = base64_encode(time());
        $user->update([
            'is_verified' => 1,
            // 'is_first_login' => 1,
            'password' => Hash::make($password),
            'temp_password' => $password,
        ]);
        Mail::to($user->email)->send(new AccountActivatedMail($user));
        return redirect()->route('users.index')->with('alert-success', 'saved');
    }

    public function deactivate(User $user)
    {
        Mail::to($user->email)->send(new AccountDeactivatedMail($user));
        $user->update([
            'is_verified' => 0,
            // 'is_first_login' => 1,
            'password' => Hash::make($password),
            'temp_password' => null,
        ]);
        return redirect()->route('users.index')->with('alert-success', 'saved');
    }

    public function accountSettings(User $user)
    {
        return view('users.account_settings', compact('user'));
    }

    public function changeAvatar(Request $request, User $user)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);
        $avatar= $request->file('image');
        $thumbnailImage = Image::make($avatar);

        $storagePath = 'images/user/avatar';
        $fileName = $user->id . '_' . date('m-d-Y H.i.s') . '.' . $avatar->getClientOriginalExtension();
        $myimage = $thumbnailImage->fit(500);
        // Storage::disk('upload')->putFileAs('images/rooms', $request->file('image'), $fileName);
        $myimage->save($storagePath . '/' .$fileName);
        $user->update([
            'avatar' => $fileName
        ]);
        /* $file = $request->file('image');
        $fileName = $request->get('name') . '_' . date('m-d-Y H.i.s') . '.' . $file->getClientOriginalExtension();
        Storage::disk('upload')->putFileAs('images/rooms', $request->file('image'), $fileName);
        $user->update([
            'image' => $fileName
        ]); */
        return redirect()->route('users.account_settings', $user->id)->with('alert-success', 'Avatar changed successfully');
    }

    public function changePassword(Request $request, User $user)
    {
        if(Auth::user()->hasrole('System Administrator')){
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'confirmed|min:8|different:old_password'
            ]);
            
            $user->update([
                'password' => Hash::make($request->get('new_password'))
            ]);

            return redirect()->route('users.account_settings', $user->id)->with('alert-success', 'Password changed successfully');
        }else{
            if(Hash::check($request->get('old_password'), $user->password)){
                $request->validate([
                    'old_password' => 'required',
                    'new_password' => 'confirmed|min:8|different:old_password'
                ]);
                
                $user->update([
                    'password' => Hash::make($request->get('new_password'))
                ]);
    
                return redirect()->route('users.account_settings', $user->id)->with('alert-success', 'Password changed successfully');
            }else{
                return redirect()->route('users.account_settings', $user->id)->with('alert-success', 'Incorrect old password');
            }
        }
    }
}
