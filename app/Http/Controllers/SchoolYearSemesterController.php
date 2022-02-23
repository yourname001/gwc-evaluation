<?php

namespace App\Http\Controllers;

use App\Models\SchoolYearSemester;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SchoolYearSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolYearSemesters = SchoolYearSemester::select("*");
        $data = [
            'schoolYearSemesters' => $schoolYearSemesters->get()
        ];

        return view('school_year_semesters.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()) {
            return response()->json([
                'modal_content' => view('school_year_semesters.create')->render()
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
            'school_year_1' => 'required',
            'school_year_2' => 'required',
            'semester' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if($request->get('active') == 1){
            SchoolYearSemester::where('active', 1)->update(['active' => 0]);
        }

        SchoolYearSemester::create([
            'active' => $request->get('active'),
            'school_year'=> $request->get('school_year_1').'-'.$request->get('school_year_2'),
            'semester'=> $request->get('semester'),
            'start_date'=> Carbon::parse($request->get('start_date')),
            'end_date'=> Carbon::parse($request->get('end_date')),
        ]);

        return redirect()->route('school_year_semesters.index')->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolYearSemester  $schoolYearSemester
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolYearSemester $schoolYearSemester)
    {
        return view('school_year_semesters.show', compact('schoolYearSemester'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolYearSemester  $schoolYearSemester
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolYearSemester $schoolYearSemester)
    {
        if(request()->ajax()) {
            return response()->json([
                'modal_content' => view('school_year_semesters.edit', compact('schoolYearSemester'))->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolYearSemester  $schoolYearSemester
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolYearSemester $schoolYearSemester)
    {
        $request->validate([
            'school_year_1' => 'required',
            'school_year_2' => 'required',
            'semester' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if($request->get('active') == 1){
            SchoolYearSemester::where('active', 1)->update(['active' => 0]);
        }

        $schoolYearSemester->update([
            'active' => ($request->get('active') == 1 ? true : false),
            'school_year'=> $request->get('school_year_1').'-'.$request->get('school_year_2'),
            'semester'=> $request->get('semester'),
            'start_date'=> Carbon::parse($request->get('start_date')),
            'end_date'=> Carbon::parse($request->get('end_date')),
        ]);

        return redirect()->route('school_year_semesters.show', $schoolYearSemester->id)->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolYearSemester  $schoolYearSemester
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolYearSemester $schoolYearSemester)
    {
        //
    }
}
