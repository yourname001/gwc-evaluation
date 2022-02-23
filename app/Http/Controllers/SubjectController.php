<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:subjects.index', ['only' => ['index']]);
		$this->middleware('permission:subjects.create', ['only' => ['create','store']]);
		$this->middleware('permission:subjects.show', ['only' => ['show']]);
		$this->middleware('permission:subjects.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:subjects.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::select('*');
        $subjects = $subjects->get();
        return view('subjects.index', compact('subjects'));
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
                'modal_content' => view('subjects.create')->render()
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
            'subject_code' => ['required', 'unique:subjects,subject_code'],
            'title' => 'required',
        ]);

        Subject::create([
            'subject_code' => $request->get('subject_code'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);

        return redirect()->route('subjects.index')->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('subjects.show', compact('subject'))->render()
            ]);
        }else{
            return view('subjects.show', compact('subject'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        if(request()->ajax()){
            return response()->json([
                'modal_content' => view('subjects.edit', compact('subject'))->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject_code' => ['required', 'unique:subjects,subject_code,'.$subject->subject_code],
            'title' => 'required',
        ]);

        $subject->update([
            'subject_code' => $request->get('subject_code'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);

        return redirect()->route('subjects.index')->with('alert-success', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if (request()->get('permanent')) {
			$subject->forceDelete();
		}else{
			$subject->delete();
		}
		return redirect()->route('subjects.index')->with('alert-danger','Deleted');
    }

    public function restore($subject)
	{
		$subject = Subject::withTrashed()->find($subject);
		$subject->restore();
		return redirect()->route('subjects.index')->with('alert-success','Restored');
    }
}
