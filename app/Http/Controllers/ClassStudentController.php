<?php

namespace App\Http\Controllers;

use App\Models\ClassStudent;
use Illuminate\Http\Request;

class ClassStudentController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		// $this->middleware('permission:class_students.index', ['only' => ['index']]);
		// $this->middleware('permission:class_students.create', ['only' => ['create','store']]);
		// $this->middleware('permission:class_students.show', ['only' => ['show']]);
		// $this->middleware('permission:class_students.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:class_students.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassStudent  $classStudent
     * @return \Illuminate\Http\Response
     */
    public function show(ClassStudent $classStudent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassStudent  $classStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassStudent $classStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassStudent  $classStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassStudent $classStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassStudent  $classStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassStudent $classStudent)
	{
		if (request()->get('permanent')) {
			$classStudent->forceDelete();
		}else{
			$classStudent->delete();
		}
		return redirect()->route('classes.show', $classStudent->class_id)->with('alert-danger','Deleted');
	}

	public function restore($classStudent)
	{
		$classStudent = ClassStudent::withTrashed()->find($classStudent);
		$classStudent->restore();
		return redirect()->route('classes.show', $classStudent->class_id)->with('alert-success','Restored');
    }
}
