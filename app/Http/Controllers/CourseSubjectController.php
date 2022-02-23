<?php

namespace App\Http\Controllers;

use App\Models\CourseSubject;
use Illuminate\Http\Request;

class CourseSubjectController extends Controller
{
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
        $request->validate([
            'course' => 'required',
            'subject' => 'required',
            'year_level' => 'required',
            'semester' => 'required',
        ]);
        
        foreach($request->get('subject') as $subject)
        {
            CourseSubject::create([
                'course_id' => $request->get('course'),
                'year_level' => $request->get('year_level'),
                'semester' => $request->get('semester'),
                'subject_id' => $subject
            ]);
        }

        return redirect()->route('courses.show', $request->get('course'))->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseSubject  $courseSubject
     * @return \Illuminate\Http\Response
     */
    public function show(CourseSubject $courseSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseSubject  $courseSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseSubject $courseSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseSubject  $courseSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseSubject $courseSubject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseSubject  $courseSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseSubject $courseSubject)
    {
        //
    }
}
