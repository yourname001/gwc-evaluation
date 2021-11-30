<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuration\RolePermission\Role;
use App\Models\User;
use App\Models\UserFaculty;
use App\Models\Section;
use App\Models\FacultySection;
use App\Models\Department;
use Image;

class FacultyController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:faculties.index', ['only' => ['index']]);
		$this->middleware('permission:faculties.create', ['only' => ['create','store']]);
		$this->middleware('permission:faculties.show', ['only' => ['show']]);
		$this->middleware('permission:faculties.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:faculties.destroy', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faculties = Faculty::select('*');
        if(Auth::user()->hasrole('System Administrator')){
			$faculties->withTrashed();
		}
        $data = [
            'faculties' => $faculties->get()
        ];
        
		return view('faculties.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            $data = ([
                'departments' => Department::get()
            ]);
            return response()->json([
                'modal_content' => view('faculties.create', $data)->render()
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
			'faculty_id' => ['required', 'unique:faculties,faculty_id'],
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            'contact_number' => ['unique:faculties,contact_number']
        ]);

		$faculty = Faculty::create([
			'department_id' => $request->get('department'),
			'faculty_id' => $request->get('faculty_id'),
			'first_name' => $request->get('first_name'),
			'middle_name' => $request->get('middle_name'),
            'last_name' => $request->get('last_name'),
            'suffix' => $request->get('suffix'),
			'gender' => $request->get('gender'),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);
        
        if($request->get('add_user_account')){
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $user = User::create([
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password'))
            ]);

            $user->assignRole(3);

            UserFaculty::create([
                'user_id' => $user->id,
                'faculty_id' => $faculty->id
            ]);

            
        }
		return redirect()->route('faculties.index')->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
		return view('faculties.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        if(request()->ajax()){
            $data = ([
                'departments' => Department::get(),
                'faculty' => $faculty,
            ]);
            return response()->json([
                'modal_content' => view('faculties.edit', $data)->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
			'faculty_id' => ['required', 'unique:faculties,faculty_id,'.$faculty->id],
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            'contact_number' => ['unique:faculties,contact_number,'.$faculty->id]
        ]);

		$faculty->update([
            'department_id' => $request->get('department'),
			'faculty_id' => $request->get('faculty_id'),
			'first_name' => $request->get('first_name'),
			'middle_name' => $request->get('middle_name'),
			'last_name' => $request->get('last_name'),
			'suffix' => $request->get('suffix'),
			'gender' => $request->get('gender'),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);

        return redirect()->route('faculties.show', $faculty->id)->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
	{
		if (request()->get('permanent')) {
			$faculty->forceDelete();
		}else{
			$faculty->delete();
		}
		return back()->with('alert-danger','Deleted');
	}

	public function restore($faculty)
	{
		$faculty = Faculty::withTrashed()->find($faculty);
		$faculty->restore();
		return back()->with('alert-success','Restored');
    }

    public function changeAvatar(Request $request, Faculty $faculty)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);
        $avatar= $request->file('image');
        $thumbnailImage = Image::make($avatar);

        $storagePath = 'images/faculty';
        $fileName = $faculty->id . '_' . date('m-d-Y H.i.s') . '.' . $avatar->getClientOriginalExtension();
        $myimage = $thumbnailImage->fit(500);
        $myimage->save($storagePath . '/' .$fileName);
        $faculty->update([
            'image' => $fileName
        ]);
        return redirect()->route('faculties.show', $faculty->id)->with('alert-success', 'Saved');
    }
    
}
