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
        'is_active',
        'course_id',
        'faculty_id',
        'section',
        'school_year',
        'schedule',
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function faculty()
    {
        return $this->belongsTo('App\Models\Faculty', 'faculty_id')->withTrashed();
    }
    
    public function students()
    {
        if(Auth::user()->hasRole('System Administrator')){
            return $this->hasMany('App\Models\ClassStudent', 'class_id')->withTrashed();
        }
        return $this->hasMany('App\Models\ClassStudent', 'class_id');
    }

}
