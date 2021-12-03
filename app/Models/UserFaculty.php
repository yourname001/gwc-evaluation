<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Auth;

class UserFaculty extends Model
{
	use SoftDeletes;
    
    protected $table = 'user_faculties';

    protected $fillable = [
        'user_id',
        'faculty_id'
    ];

    public function user(){
        /* if(Auth::user()->hasrole('System Administrator')){
            return $this->belongsTo('App\Models\User', 'user_id')->withTrashed();
        }else{
            return $this->belongsTo('App\Models\User', 'user_id');
        } */
        return $this->belongsTo('App\Models\User', 'user_id')->withTrashed();
    }

    public function faculty(){
        return $this->belongsTo('App\Models\Faculty', 'faculty_id');
    }
}
