<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SchoolYearSemester extends Model
{
    use SoftDeletes;
    
    protected $table = 'school_year_semester';
    
    protected $fillable = [
        'active',
        'semester',
        'school_year',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getStatus()
    {
        $now = Carbon::now();
        $status = "";
        if($this->active == 1 && $this->end_date->gt($now)){
            $status = 'active';
        }
        elseif($this->end_date->lt($now)){
            $status = 'ended';
        }
        elseif($this->status == 0){
            $status = 'inactive';
        }
        return $status;
    }

    public function getStatusBadge()
    {
        $now = Carbon::now();
        $status = "";
        if($this->active == 1 && $this->end_date->gt($now)){
            $status = '<span class="badge badge-success">Active</span>';
        }
        elseif($this->end_date->lt($now)){
            $status = '<span class="badge badge-info">Ended</span>';
        }
        elseif($this->status == 0){
            $status = '<span class="badge badge-secondary">Inactive</span>';
        }
        return $status;
    }

    public function getSemester()
    {
        $year = "";
        if(isset($this->id)){
            $year = $this->ordinal($this->semester)." Semester";
        }
        return $year;
    }

    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    public function classes()
    {
        return $this->hasMany('App\Models\Classes', 'school_year_semester_id');
    }

}
