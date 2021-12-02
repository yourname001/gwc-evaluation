<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\EvaluationFaculty;
use App\Models\EvaluationClasses;
use App\Models\Classes;

class Faculty extends Model
{
    use SoftDeletes;
    
    protected $table = 'faculties';

    protected $fillable = [
        'image',
        'faculty_id',
        'department_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'gender',
        'contact_number',
        'address'
    ];

    public function user() {
        return $this->hasOne('App\Models\UserFaculty', 'faculty_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

    public function getFacultyName()
	{
		$name = "N/A";
		if($this->id){
			$name = $this->first_name.' '.
				(is_null($this->middle_name) ? '' : $this->middle_name[0].'. ').
				$this->last_name;
		}
		return $name;
    }

    public static function getName()
	{
		$name = "N/A";
		if($this->id){
			$name = $this->first_name.' '.
				(is_null($this->middle_name) ? '' : $this->middle_name[0].'. ').
				$this->last_name.
				' '.$this->suffix;
		}
		return $name;
    }
    
    public function facultyEvaluations()
    {
        return EvaluationFaculty::where(['faculty_id', $this->id]);
    }

    public function classes()
    {
        return $this->hasMany('App\Models\Classes', 'faculty_id');
    }

    public function hasClass($classID)
    {
        if(Classes::where([
            ['id', $classID],
            ['faculty_id', $this->id],
        ])->exists()){
            return true;
        }
        return false;
    }

    /* public function evaluations()
    {
        $classesID = Classes::where('faculty_id', $this->id)->get('id');
        $evaluationClasses = EvaluationClasses::where('$classesID')
    } */
    
    /** 
     * $format = 'f-m-l'
     * $format = 'l-f-m'
     * $format = 'l-f-M'
     */
    public function fullname($format)
	{
        $format = explode('-', $format);
        $name = "";
        for ($i=0; $i < count($format); $i++) { 
            switch ($format[$i]) {
                case 'f':
                    if($i == 0)
                        $name .= $this->first_name;
                    elseif($i == 1)
                        $name .= $this->first_name;
                    break;
                case 'm':
                    if(!is_null($this->middle_name)){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'M':
                    if(!is_null($this->middle_name)){
                        if($i == 1){
                            $name .= ' '.$this->middle_name[0].'. ';
                        }else{
                            $name .= ' '.$this->middle_name[0].'. ';
                        }
                    }
                    break;
                case 'l':
                    if($i == 0){
                        $name .= $this->last_name.', ';
                    }elseif($i == 2){
                        $name .= ' '.$this->last_name;
                    }
                    break;
                case 's':
                    // if($i == 3){
                        $name .= $this->suffix;
                    // }
                    break;
                
                default:
                $name = $this->first_name.' '.
                    (is_null($this->middle_name) ? '' : $this->middle_name[0].'. ').
                    $this->last_name.
				    ' '.$this->suffix;
                    break;
            }
        }
		
		return $name;
    }
    
    public function avatar()
    {
        $avatar = 'images/'.$this->gender.'.jpg';
        if(!is_null($this->image)){
            $avatar = 'images/faculty/'.$this->image;
        }
        return $avatar;
    }

}
