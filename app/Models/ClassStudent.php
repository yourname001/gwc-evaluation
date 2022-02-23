<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassStudent extends Model
{
    use SoftDeletes;
    
    protected $table = 'class_students';

    protected $fillable = [
        'class_id',
        'student_id',
    ];

    public function class()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id')->withTrashed();
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id')->withTrashed();
    }
}
