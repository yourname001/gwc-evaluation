<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:courses.index', ['only' => ['index']]);
		$this->middleware('permission:courses.create', ['only' => ['create','store']]);
		$this->middleware('permission:courses.show', ['only' => ['show']]);
		$this->middleware('permission:courses.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:courses.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::select('*');
        $courses = $courses->get();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('courses.create')->render()
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
            'course_code' => ['required', 'unique:courses,course_code'],
            'title' => 'required',
        ]);

        Course::create([
            'course_code' => $request->get('course_code'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);

        return redirect()->route('courses.index')->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('courses.show', compact('course'))->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('courses.edit', compact('course'))->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => ['required', 'unique:courses,course_code,'.$course->course_code],
            'title' => 'required',
        ]);

        $course->update([
            'course_code' => $request->get('course_code'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);

        return redirect()->route('courses.index')->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
	{
		if (request()->get('permanent')) {
			$course->forceDelete();
		}else{
			$course->delete();
		}
		return redirect()->route('courses.index')->with('alert-danger','Deleted');
	}

	public function restore($course)
	{
		$course = Course::withTrashed()->find($course);
		$course->restore();
		return redirect()->route('courses.index')->with('alert-success','Restored');
    }
}
