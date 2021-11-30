<?php

namespace App\Http\Controllers;

use App\Models\EvaluationStudent;
use App\Models\EvaluationStudentResponse;
use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\EvaluationFaculty;
use App\Models\EvaluationClasses;
use App\Models\Question;
use Auth;

class EvaluationStudentController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:evaluation_students.index', ['only' => ['index']]);
		$this->middleware('permission:evaluation_students.create', ['only' => ['create','store']]);
		$this->middleware('permission:evaluation_students.show', ['only' => ['show']]);
		$this->middleware('permission:evaluation_students.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:evaluation_students.destroy', ['only' => ['destroy']]);
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
        if(request()->ajax()) {
            $evaluationClassID = request()->get('evaluation_class_id');
            $data = [
                'evaluation_class' => EvaluationClasses::find($evaluationClassID),
                'questions' => Question::where('is_active', 1)->get()
            ];
            return response()->json([
                'modal_content' => view('evaluation_students.create', $data)->render()
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
            'evaluation_class' => 'required',
            'question' => 'required'
        ]);
        $evaluationStudent = EvaluationStudent::create([
            'evaluation_class_id' => $request->get('evaluation_class'),
            'student_id' => Auth::user()->student->student_id,
            'positive_comments' => $request->get('positive_comments'),
            'negative_comments' => $request->get('negative_comments'),
        ]);

        foreach($request->get('question') as $question_id => $response){
            EvaluationStudentResponse::create([
                'evaluation_student_id' => $evaluationStudent->id,
                'question_id' => $question_id,
                'question' => Question::find($question_id)->question,
                'answer' => $response
            ]);
        }

        return redirect()->route('evaluations.index')->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EvaluationStudent  $evaluationStudent
     * @return \Illuminate\Http\Response
     */
    public function show(EvaluationStudent $evaluationStudent)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('evaluation_students.show', compact('evaluationStudent'))->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EvaluationStudent  $evaluationStudent
     * @return \Illuminate\Http\Response
     */
    public function edit(EvaluationStudent $evaluationStudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EvaluationStudent  $evaluationStudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvaluationStudent $evaluationStudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EvaluationStudent  $evaluationStudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvaluationStudent $evaluationStudent)
    {
        //
    }
}
