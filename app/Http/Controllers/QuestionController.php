<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::select('*');
        $data = [
            'questions' => $questions->get()
        ];
        
        return view('question_management.questions.index', $data);
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
                'modal_content' => view('question_management.questions.create')->render()
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
            'question' => 'required'
        ]);

        Question::create([
            'question' => $request->get('question'),
            'is_active' => $request->get('is_active')
        ]);

        return redirect()->route('questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        if(request()->ajax()) {
            return response()->json([
                'modal_content' => view('question_management.questions.show', compact('question'))->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        if(request()->ajax()) {
            return reponse()->json([
                'modal_content' => view('question_management.questions.edit', compact('question'))->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required'
        ]);

        $question->update([
            'question' => $request->get('question'),
            'is_active' => $request->get('is_active'),
        ]);

        return redirect()->route('questions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
	{
		if (request()->get('permanent')) {
			$question->forceDelete();
		}else{
			$question->delete();
		}
		return back()->with('alert-danger','Deleted');
	}

	public function restore($question)
	{
		$question = Question::withTrashed()->find($question);
		$question->restore();
		return back()->with('alert-success','Restored');
	}
}
