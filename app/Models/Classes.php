<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Classes extends Model
{
    use SoftDeletes;
    
    protected $table = 'classes';

    protected $fillable = [
        'school_year_semester_id',
        'subject_id',
        'faculty_id',
        'section',
        'schedule',
    ];

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty', 'faculty_id')->withTrashed();
    }

    public function schoolYearSemester()
    {
        return $this->belongsTo('App\Models\SchoolYearSemester', 'school_year_semester_id');
    }
    
    public function students()
    {
        if(Auth::user()->hasRole('System Administrator')){
            return $this->hasMany('App\Models\ClassStudent', 'class_id')->withTrashed();
        }
        return $this->hasMany('App\Models\ClassStudent', 'class_id');
    }

}
