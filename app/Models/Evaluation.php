<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Auth;

class Evaluation extends Model
{
    use SoftDeletes;
    
    protected $table = 'evaluations';

    protected $fillable = [
        'title',
        'status',
        'class_id',
        'faculty_id',
        'start_date',
        'end_date',
        'description',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function evaluationStudents()
    {
        return $this->hasMany('App\Models\EvaluationStudent', 'evaluation_id');
    }

    public function evaluationFaculties()
    {
        return $this->hasMany('App\Models\EvaluationFaculty', 'evaluation_id');
    }

    public function evaluationClasses()
    {
        if(Auth::user()->hasrole('System Administrator')){
            return $this->hasMany('App\Models\EvaluationClasses', 'evaluation_id')->withTrashed();
        }
        return $this->hasMany('App\Models\EvaluationClasses', 'evaluation_id');
    }

    public function class()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id');
    }

    public function getStatus()
    {
        $now = Carbon::now();
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $status = 'incoming';

        if($this->start_date->lt($now) && $this->end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($this->end_date->lt($now)){
            $status = 'ended';
        }
        return $status;
    }

    public function getStatusBadge()
    {
        $status = $this->getStatus();
        switch ($status) {
            case 'incoming':
                $status = '<span class="badge badge-warning">Incoming</span>';
                break;
            case 'ongoing':
                $status = '<span class="badge badge-success">Ongoing</span>';
                break;
            case 'ended':
                $status = '<span class="badge badge-primary">Ended</span>';
                break;
            
        }
        return $status;
    }
}
