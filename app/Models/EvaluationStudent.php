<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluationStudent extends Model
{
    use SoftDeletes;
    
    protected $table = 'evaluation_students';

    protected $fillable = [
        // 'evaluation_faculty_id',
        'evaluation_class_id',
        'student_id',
        'positive_comments',
        'negative_comments',
    ];

    /* public function evaluationFaculty()
    {
        return $this->belongsTo('App\Models\EvaluationFaculty', 'evaluation_faculty_id');
    }
     */
    public function evaluationClass()
    {
        return $this->belongsTo('App\Models\EvaluationClasses', 'evaluation_class_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function evaluationStudentReponses()
    {
        return $this->hasMany('App\Models\EvaluationStudentResponse', 'evaluation_student_id');
    }

}
