<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;
    
    protected $table = 'subjects';

    protected $fillable = [
        'subject_code',
        'title',
        'description',
    ];

    public function classes()
    {
        return $this->hasMany('App\Models\Classes', 'subject_id');
    }
}
