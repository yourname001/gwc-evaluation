<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluationStudentResponse extends Model
{
    use SoftDeletes;
    
    protected $table = 'evaluation_student_responses';

    protected $fillable = [
        'evaluation_student_id',
        'question_id',
        'question',
        'answer',
    ];

    public function evaluationStudent()
    {
        return $this->belongsTo('App\Models\EvaluationStudent', 'evaluation_student_id');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }

    /* public function countAgree()
    {
        return self::where('question_id')
    } */
}
