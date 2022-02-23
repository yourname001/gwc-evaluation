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
        'rating',
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

    public function getRating()
    {
        $rating = "";
        switch ($this->rating) {
            case '0':
                $rating = "Not Applicable";
                break;
            case '3-2':
                $rating = "Needs Improvement";
                break;
            case '5-6':
                $rating = "Need to excel  in areas which focuses in the learner centered aspects, good in some areas";
                break;
            case '7-8':
                $rating = "Good but need to excel in some areas";
                break;
            case '9-10':
                $rating = "Excellent!";
                break;
            default:
                $rating = "Not Applicable";
                break;
        }
        return $rating;
    }

}
