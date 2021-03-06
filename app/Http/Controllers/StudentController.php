<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuration\RolePermission\Role;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\Section;
use App\Models\StudentSection;
use App\Models\FileAttachment;
use App\Models\UserFileAttachment;
use Image;

class StudentController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:students.index', ['only' => ['index']]);
		$this->middleware('permission:students.create', ['only' => ['create','store']]);
		$this->middleware('permission:students.show', ['only' => ['show']]);
		$this->middleware('permission:students.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:students.destroy', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::select('*');
        if(Auth::user()->hasrole('System Administrator')){
			$students->withTrashed();
		}
        $data = [
            'studentsByYearLevel' => $students->orderBy('year_level', 'ASC')->get()->groupBy('year_level')
        ];
        
		return view('students.index', $data);
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
        $data = ([
			'roles' => $roles->get(),
			
		]);
		/* if(!Auth::user()->hasrole('System Administrator')){
			$data = ([
				'student' => $student,
			]);
		} */

		return response()->json([
			'modal_content' => view('students.create', $data)->render()
		]);
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
			'student_id' => ['required', 'unique:students,student_id'],
			'first_name' => 'required',
			'last_name' => 'required',
			'year_level' => 'required',
            'gender' => 'required',
            'contact_number' => ['unique:students,contact_number']
        ]);

		$student = Student::create([
			'student_id' => strtoupper($request->get('student_id')),
			'year_level' => $request->get('year_level'),
			'first_name' => strtoupper($request->get('first_name')),
			'middle_name' => strtoupper($request->get('middle_name')),
			'last_name' => strtoupper($request->get('last_name')),
			'suffix' => strtoupper($request->get('suffix')),
			'gender' => $request->get('gender'),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);

        /* StudentSection::create([
            'section_id' => $request->get('section'),
            'student_id' => $student->id
        ]); */
        
        if($request->get('add_user_account')){
            $request->validate([
                // 'username' => ['required', 'string', 'max:255', 'unique:users,username'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $password = base64_encode(time());

            $user = User::create([
                'username' => $request->get('student_id'),
                'email' => $request->get('email'),
                'password' => Hash::make($password),
                'temp_password' => $password
            ]);

            $user->assignRole(4);

            UserStudent::create([
                'user_id' => $user->id,
                'student_id' => $student->id
            ]);
        }
		return back()->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
		return view('students.show', compact('student'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {   
        return response()->json([
			'modal_content' => view('students.edit', compact('student'))->render()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
			'student_id' => ['required', 'unique:students,student_id,'.$student->id],
			'year_level' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            'contact_number' => ['unique:students,contact_number,'.$student->id]
        ]);

		$student->update([
			'student_id' => strtoupper($request->get('student_id')),
			'year_level' => $request->get('year_level'),
			'first_name' => strtoupper($request->get('first_name')),
			'middle_name' => strtoupper($request->get('middle_name')),
			'last_name' => strtoupper($request->get('last_name')),
			'suffix' => strtoupper($request->get('suffix')),
			'gender' => $request->get('gender'),
			'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);

        /* $student->section->update([
            'section_id' => $request->get('section')
        ]); */

        return back()->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
	{
		if (request()->get('permanent')) {
			$student->forceDelete();
		}else{
			$student->delete();
		}
		return redirect()->route('students.index')->with('alert-danger','Deleted');
		// return redirect()->route('users.index')->with('alert-danger','User successfully deleted');
	}

	public function restore($student)
	{
		$student = Student::withTrashed()->find($student);
		$student->restore();
		return redirect()->route('students.index')->with('alert-success','Restored');
		// return redirect()->route('users.index')->with('alert-success','User successfully restored');
    }

    public function changeAvatar(Request $request, Student $student)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ],
        [
            'image.image' => 'Invalid file type.',
            'image.mimes' => 'Avatar must jpg, jpeg, or png.',
        ]);
        $avatar= $request->file('image');
        $thumbnailImage = Image::make($avatar);

        $storagePath = 'images/student';
        $fileName = $student->id . '_' . date('m-d-Y H.i.s') . '.' . $avatar->getClientOriginalExtension();
        $myimage = $thumbnailImage->fit(500);
        $myimage->save($storagePath . '/' .$fileName);
        $student->update([
            'image' => $fileName
        ]);
        return redirect()->route('students.show', $student->id)->with('alert-success', 'Avatar changed successfully');
    }

    public function upodateStatus(Request $request, Student $student)
    {
        $student->update([
            'status' => $request->get('status')
        ]);
        return redirect()->route('students.show', $student->id)->with('alert-success', 'saved');
    }
}
