<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\EvaluationStudent;
use App\Models\EvaluationStudentResponse;
use Auth;


class EvaluationClasses extends Model
{
    use SoftDeletes;
    
    protected $table = 'evaluation_classes';

    protected $fillable = [
        'evaluation_id',
        'class_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function evaluation()
    {
        return $this->belongsTo('App\Models\Evaluation', 'evaluation_id');
    }

    public function class()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id');
    }

    public function evaluationStudents()
    {
        return $this->hasMany('App\Models\EvaluationStudent', 'evaluation_class_id');
    }

    public function evaluationStudentResponses()
    {
        $studentResponses = EvaluationStudentResponse::wherein('evaluation_student_id', EvaluationStudent::where('evaluation_class_id', $this->id)->get('id'))->get();
        return $studentResponses;
    }
    
    public function isDone()
    {
        $evaluationStudent = EvaluationStudent::where([
            ['evaluation_class_id', $this->id],
            ['student_id', Auth::user()->student->student_id],
        ])->exists();
        if($evaluationStudent){
            return True;
        }
        return False;
    }

    public function studentResponseID()
    {
        $evaluationStudent = EvaluationStudent::where([
            ['evaluation_class_id', $this->id],
            ['student_id', Auth::user()->student->student_id],
        ])->first();
        
        return $evaluationStudent->id;
    }
}
