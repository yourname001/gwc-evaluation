<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    
    protected $table = 'courses';

    protected $fillable = [
        'course_code',
        'title',
        'description',
    ];

    public function classes()
    {
        return $this->hasMany('App\Models\Classes', 'course_id');
    }
}
