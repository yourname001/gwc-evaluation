<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    
    protected $table = 'courses';

    protected $fillable = [
        'department_id',
        'name',
        'description',
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

    public function subjects()
    {
        return $this->hasMany('App\Models\CourseSubject', 'course_id');
    }

    public function students()
    {
        return $this->hasMany('App\Models\Student', 'course_id');
    }

}
