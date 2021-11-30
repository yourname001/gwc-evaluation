<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationFaculty;
use App\Models\EvaluationClasses;
use App\Models\EvaluationStudent;
use App\Models\EvaluationStudentResponse;
use App\Models\Faculty;
use App\Models\Classes;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Charts\EvaluationFacultyChart;
use App\Charts\SampleChart;
use PDF;
use Auth;

class EvaluationController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:evaluations.index', ['only' => ['index']]);
		$this->middleware('permission:evaluations.create', ['only' => ['create','store']]);
		$this->middleware('permission:evaluations.show', ['only' => ['show']]);
		$this->middleware('permission:evaluations.edit', ['only' => ['edit','update']]);
		$this->middleware('permission:evaluations.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluations = Evaluation::select('*');

        if(Auth::user()->hasrole('Student')){
            $data = [
                'evaluations' => $evaluations->get()
            ];
            return view('evaluations.student_index', $data);
        }elseif(Auth::user()->hasrole('Faculty')){
            $evaluationClassChart = [[]];
            $facultyClassesIDs = Classes::where('faculty_id', Auth::user()->faculty->faculty_id)->get('id');
            $facultyEvaluations = EvaluationClasses::whereIn('class_id', $facultyClassesIDs)->get();
            // foreach($evaluations->get() as $evaluation){
            /* foreach($facultyEvaluations->groupBy('evaluation_id') as $evaluationID => $facultyEvaluation){
                $evaluationStudents = EvaluationStudent::where([
                    ['evaluation_class_id', $facultyEvaluation->id]
                ])->get('id');
                // $evaluationStudentResponses = EvaluationStudentResponse::whereIn('evaluation_student_id', $evaluationStudents);
                // foreach($evaluationStudentResponses->get()->groupBy('question_id') as $questionID => $responses){
                if($evaluationStudents->count() > 0){
                    foreach($facultyEvaluation->evaluationStudentResponses()->groupBy('question_id') as $questionID => $responses){
                        $evaluationClassChart[$facultyEvaluation->id][$questionID] = new EvaluationFacultyChart;
                        $evaluationClassChart[$facultyEvaluation->id][$questionID]->height(250);
                        $labels = ['strongly agree','agree','disagree','strongly disagree'];
                        $answers = [];
                        $finalAnswerCount = [];
                        $finalLabels = [];
                        foreach($labels as $label){
                            $answers[$label] = 0;
                        }
                        foreach($responses as $response){
                            $answers[$response->answer] += 1;
                        }
                        foreach($labels as $label){
                            $finalAnswerCount[] = $answers[$label];
                            $finalLabels[] = $label;
                        }
                        $evaluationClassChart[$facultyEvaluation->id][$questionID]->labels($finalLabels);
                        $evaluationClassChart[$facultyEvaluation->id][$questionID]->dataset('responses', 'bar', $finalAnswerCount)->backgroundColor('#007bff')->color('#007bff');
                        $evaluationClassChart[$facultyEvaluation->id][$questionID]->options([
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
                }
            } */
            // }
            $data = [
                'facultyEvaluations' => $facultyEvaluations,
                // 'evaluationClassChart' => $evaluationClassChart,
                // 'evaluationChartIDs' => $evaluationChartIDs
            ];
            return view('evaluations.faculty_index', $data);
        }else{
            $data = [
                'evaluations' => $evaluations->get()
            ];
            return view('evaluations.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()) {
            $data = [
                'faculties' => Faculty::get(),
                'classes' => Classes::get(),
            ];

            return response()->json([
                'modal_content' => view('evaluations.create', $data)->render()
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
            'title' => 'required',
            // 'faculties' => 'required',
            'classes' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $now = Carbon::now();
        $start_date = Carbon::parse($request->get('start_date'));
        $end_date = Carbon::parse($request->get('end_date'));
        $status = 'incoming';

        if($start_date->lt($now) && $end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($end_date->lt($now)){
            $status = 'ended';
        }

        $evaluation = Evaluation::create([
            'title' => $request->get('title'),
            'status' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'description' => $request->get('description'),
        ]);

        if($request->get('classes')) {
            $classes = $request->get('classes');
            foreach($classes as $class_id){
                EvaluationClasses::create([
                    'evaluation_id' => $evaluation->id,
                    'class_id' => $class_id,
                ]);
            }
        }

        return redirect()->route('evaluations.index')->with('alert-success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        $evaluationClassChart = [[]];
        $labelColors = [
            'strongly agree' => '#28a745',
            'agree' => '#20c997',
            'disagree' => '#ffc107',
            'strongly disagree' => '#fd7e14',
        ];
        $choices = ['strongly agree','agree','disagree','strongly disagree'];
        // $labels = ['strongly agree','agree','disagree','strongly disagree'];
        // $evaluationClassChart[$evaluationClass->id][$questionID]->dataset('responses', 'bar', $finalAnswerCount)->backgroundColor(['#28a745', '#20c997', '#ffc107', '#fd7e14'])->color(['#28a745', '#20c997', '#ffc107', '#fd7e14']);
        /* foreach($evaluation->evaluationClasses as $evaluationClass){
            $evaluationClassChart[$evaluationClass->id] = new EvaluationFacultyChart;
            $evaluationClassChart[$evaluationClass->id]->height(100);
            $labels = [];
            $countAnswers = [[]];
            $stronglyAgree = [];
            $agree = [];
            $disagree = [];
            $stronglyDisagree = [];
            foreach($evaluationClass->evaluationStudentResponses()->groupBy('question') as $question => $responses){
                $labels[] = $question;
                // $labels[] = explode(" ",$question);
            }
            $evaluationClassChart[$evaluationClass->id]->labels($labels);
            
            foreach($evaluationClass->evaluationStudentResponses()->groupBy('question') as $question => $responses){
                $answers = [];
                foreach($choices as $choice){
                    $answers[$choice] = 0;
                }
                foreach($responses as $response){
                    $answers[$response->answer] += 1;
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
            }
            
            $evaluationClassChart[$evaluationClass->id]->dataset('Strongly Agree', 'bar', $stronglyAgree)->backgroundColor('#28a745')->color('#28a745');
            $evaluationClassChart[$evaluationClass->id]->dataset('Agree', 'bar', $agree)->backgroundColor('#20c997')->color('#20c997');
            $evaluationClassChart[$evaluationClass->id]->dataset('Disgree', 'bar', $disagree)->backgroundColor('#ffc107')->color('#ffc107');
            $evaluationClassChart[$evaluationClass->id]->dataset('Strongly Disgree', 'bar', $stronglyDisagree)->backgroundColor('#fd7e14')->color('#fd7e14');
            $evaluationClassChart[$evaluationClass->id]->options([
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
        } */
        /* foreach($evaluation->evaluationClasses as $evaluationClass){
            foreach($evaluationClass->evaluationStudentResponses()->groupBy('question_id') as $questionID => $responses){
                $evaluationClassChart[$evaluationClass->id][$questionID] = new EvaluationFacultyChart;
                $evaluationClassChart[$evaluationClass->id][$questionID]->height(250);
                $labels = ['strongly agree','agree','disagree','strongly disagree'];
                $answers = [];
                $finalAnswerCount = [];
                $finalLabels = [];
                foreach($labels as $label){
                    $answers[$label] = 0;
                }
                foreach($responses as $response){
                    $answers[$response->answer] += 1;
                }
                foreach($labels as $label){
                    $finalAnswerCount[] = $answers[$label];
                    $finalLabels[] = $label;
                }
                $evaluationClassChart[$evaluationClass->id][$questionID]->labels($finalLabels);
                $evaluationClassChart[$evaluationClass->id][$questionID]->dataset('responses', 'bar', $finalAnswerCount)->backgroundColor('#007bff')->color('#007bff');
                $evaluationClassChart[$evaluationClass->id][$questionID]->options([
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
        } */
        $data = [
            'evaluation' => $evaluation,
            'evaluationClassChart' => $evaluationClassChart,
            // 'evaluationChartIDs' => $evaluationChartIDs
        ];
        return view('evaluations.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        if(request()->ajax()) {
            $data = [
                'classes' => Classes::get(),
                'evaluation' => $evaluation,
                'evaluationClassIDs' => $evaluation->evaluationClasses->pluck('class_id')->toArray(),
            ];
            return response()->json([
                'modal_content' => view('evaluations.edit', $data)->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'title' => 'required',
            // 'faculties' => 'required',
            'classes' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $now = Carbon::now();
        $start_date = Carbon::parse($request->get('start_date'));
        $end_date = Carbon::parse($request->get('end_date'));
        $status = 'incoming';

        if($start_date->lt($now) && $end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($end_date->lt($now)){
            $status = 'ended';
        }

        $evaluation->update([
            'title' => $request->get('title'),
            'status' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'description' => $request->get('description'),
        ]);

        $evaluationClassIDs = [];

        if($request->get('classes')) {
            $classes = $request->get('classes');
            
            foreach($classes as $class_id){
                $query = EvaluationClasses::where([
                    ['evaluation_id', $evaluation->id],
                    ['class_id', $class_id],
                ])->doesntExist();
                if($query){
                    $evaluationClass = EvaluationClasses::create([
                        'evaluation_id' => $evaluation->id,
                        'class_id' => $class_id,
                    ]);
                }
                $evaluationClassIDs[] = $class_id;
            }
        }

        EvaluationClasses::where('evaluation_id', $evaluation->id)->whereNotIn('class_id', $evaluationClassIDs)->delete();

        return redirect()->route('evaluations.show', $evaluation->id)->with('alert-success', 'saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
	{
		if (request()->get('permanent')) {
			$evaluation->forceDelete();
		}else{
			$evaluation->delete();
		}
		return redirect()->route('evaluations.index')->with('alert-danger','Deleted');
	}

	public function restore($evaluation)
	{
		$evaluation = Evaluation::withTrashed()->find($evaluation);
		$evaluation->restore();
		return redirect()->route('evaluations.index')->with('alert-success','Restored');
    }
    
    /* public function exportFacultyEvaluationPDF(FacultyEvaluqation);
    {
        
        $pdf = PDF::loadView('pdf.invoice', $data);
        return $pdf->download('invoice.pdf');
    } */
}
