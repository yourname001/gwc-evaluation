<?php

namespace App\Http\Controllers;

use App\Models\EvaluationClasses;
use Illuminate\Http\Request;
use App\Charts\EvaluationClassChart;
use App\Exports\EvaluationClassExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacultyEvaluationResultMail;

class EvaluationClassesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:evaluation_classes.index', ['only' => ['index']]);
		$this->middleware('permission:evaluation_classes.create', ['only' => ['create','store']]);
		$this->middleware('permission:evaluation_classes.show', ['only' => ['show']]);
		$this->middleware('permission:evaluation_classes.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:evaluation_classes.destroy', ['only' => ['destroy']]);
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
     * @param  \App\Models\EvaluationClasses  $evaluationClasses
     * @return \Illuminate\Http\Response
     */
    public function show(EvaluationClasses $evaluationClasses)
    {
        $evaluationClassChart = [];
        $choices = ['strongly agree','agree','disagree','strongly disagree'];
        foreach($evaluationClasses->evaluationStudentResponses()->groupBy('question_id') as $questionID => $responses){
            $evaluationClassChart[$questionID] = new EvaluationClassChart;
            $evaluationClassChart[$questionID]->height(250);
            $labels = ['strongly agree','agree','disagree','strongly disagree'];
            $answers = [];
            // $finalAnswerCount = [];
            // $finalLabels = [];
            $stronglyAgree = [];
            $agree = [];
            $disagree = [];
            $stronglyDisagree = [];
            foreach($labels as $label){
                $answers[$label] = 0;
            }
            foreach($responses as $response){
                $answers[$response->answer] += 1;
            }
            foreach($labels as $label){
                $finalAnswerCount[] = $answers[$label];
                // $finalLabels[] = $label;
            }
            foreach($choices as $choice){
                switch ($choice) {
                    case 'strongly agree':
                        $stronglyAgree[] = $answers[$choice];
                        break;
                    case 'agree':
                        $agree[] = $answers[$choice];
                        break;
                    case 'disagree':
                        $disagree[] = $answers[$choice];
                        break;
                    case 'strongly disagree':
                        $stronglyDisagree[] = $answers[$choice];
                        break;
                }
            }
            $evaluationClassChart[$questionID]->labels(['responses']);
            /* $evaluationClassChart[$questionID]->dataset('Strongly Agree', 'bar', [1])->backgroundColor('#28a745')->color('#28a745');
            $evaluationClassChart[$questionID]->dataset('Agree', 'bar', [1])->backgroundColor('#20c997')->color('#20c997');
            $evaluationClassChart[$questionID]->dataset('Disgree', 'bar', [1])->backgroundColor('#ffc107')->color('#ffc107');
            $evaluationClassChart[$questionID]->dataset('Strongly Disgree', 'bar', [1])->backgroundColor('#fd7e14')->color('#fd7e14'); */
            $evaluationClassChart[$questionID]->dataset('Strongly Agree', 'bar', $stronglyAgree)->backgroundColor('#28a745')->color('#28a745');
            $evaluationClassChart[$questionID]->dataset('Agree', 'bar', $agree)->backgroundColor('#20c997')->color('#20c997');
            $evaluationClassChart[$questionID]->dataset('Disgree', 'bar', $disagree)->backgroundColor('#ffc107')->color('#ffc107');
            $evaluationClassChart[$questionID]->dataset('Strongly Disgree', 'bar', $stronglyDisagree)->backgroundColor('#fd7e14')->color('#fd7e14');
            // $evaluationClassChart[$questionID]->dataset('responses', 'bar', $finalAnswerCount)->backgroundColor('#007bff')->color('#007bff');
            $evaluationClassChart[$questionID]->options([
                // 'min-height' => '250px',
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'stepSize' => 1,
                        ]
                    ]],
                    'xAxes' => [[
                        'gridLines' => [
                            'display' => true
                        ]
                    ]]
                ]
            ]);
        }
        $data = [
            'evaluationClass' => $evaluationClasses,
            'evaluationClassChart' => $evaluationClassChart,
        ];
        /* $data = [
            'evaluation' => $evaluation
        ]; */
        return view('evaluation_classes.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EvaluationClasses  $evaluationClasses
     * @return \Illuminate\Http\Response
     */
    public function edit(EvaluationClasses $evaluationClasses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EvaluationClasses  $evaluationClasses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvaluationClasses $evaluationClasses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EvaluationClasses  $evaluationClasses
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvaluationClasses $evaluationClasses)
	{
        $evaluationID = $evaluationClasses->evaluation_id;
		if (request()->get('permanent')) {
			$evaluationClasses->forceDelete();
		}else{
			$evaluationClasses->delete();
		}
		return redirect()->route('evaluations.show', $evaluationID)->with('alert-danger','Deleted');
	}

	public function restore($evaluation)
	{
        $evaluationClasses = EvaluationClasses::withTrashed()->find($evaluation);
        $evaluationID = $evaluationClasses->evaluation_id;
		$evaluationClasses->restore();
		return redirect()->route('evaluations.show', $evaluationID)->with('alert-success','Restored');
    }

    public function export() 
    {
        /* return view('evaluation_classes.excel', [
            'evaluationClass' => EvaluationClasses::find(request()->get('evaluation_class_id'))
        ]); */
        $evaluationClass = EvaluationClasses::find(request()->get('evaluation_class_id'));
        $faculty = $evaluationClass->class->faculty;
        $fileName = $faculty->last_name.', '.$faculty->first_name.' ('.$evaluationClass->class->course->course_code.') '.date('Y-m-d-H-i-s').'.xlsx';
        
        return Excel::download(new EvaluationClassExport(
            $evaluationClass->id), $fileName
        );
        return redirect()->route('evaluations.show', $evaluationClass->evaluation_id);
    }

    public function mailToFaculty(EvaluationClasses $evaluationClasses)
    {
        // $fileName = $evaluationClasses->id.'-'.$evaluationClasses->class->faculty->fullname('').'-'.$evaluationClasses->class->course->course_code.'.xlsx';
        $evaluationClass = $evaluationClasses;
        $faculty = $evaluationClass->class->faculty;
        $fileName = $faculty->last_name.', '.$faculty->first_name.' ('.$evaluationClass->class->course->course_code.') '.date('Y-m-d-H-i-s').'.xlsx';
        Excel::store(new EvaluationClassExport($evaluationClasses->id), $fileName, 'excel');
        $filePath = 'excel-exports/'.$fileName;
        Mail::to($evaluationClasses->class->faculty->user->user->email)->send(new FacultyEvaluationResultMail($evaluationClasses, $filePath));
        return redirect()->route('evaluation_classes.show', $evaluationClasses->id);
    }
}
