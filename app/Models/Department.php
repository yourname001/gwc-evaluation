<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    
    protected $table = 'departments';

    protected $fillable = [
        'name',
    ];

    public function faculties()
    {
        return $this->hasMany('App\Models\Faculty', 'department_id');
    }
}
