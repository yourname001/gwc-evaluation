<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ClassStudent;
use App\Models\Classes;
use App\Models\SchoolYearSemester;
use App\Models\CourseSubject;

class Student extends Model
{
	use SoftDeletes;
    
    protected $table = 'students';

    protected $fillable = [
        'image',
        'status',
        'course_id',
        'student_id',
        'year_level',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'contact_number',
        'address',
        'suffix'
    ];

    public function getCurriculumStatus()
    {
        $activeSemester = SchoolYearSemester::where('active', 1)->first();
        if(!isset($activeSemester->id)){
            return "N/A";
        }
        $activeClasses = Classes::where('school_year_semester_id', $activeSemester->id);
        $studentActiveClasses = ClassStudent::where('student_id', $this->id)->whereIn('class_id', $activeClasses->get('id'));
        $activeCurriculumSubjects = CourseSubject::where([
            ['semester', $activeSemester->semester],
            ['year_level', $this->year_level],
        ])->get();
        $studentClasses = ClassStudent::where('student_id', $this->id);
        $studentActiveSubjects = Classes::whereIn('id', $studentClasses->get('class_id'))->pluck('subject_id');
        foreach($activeCurriculumSubjects as $curriculum){
            if(Classes::whereIn('id', $studentClasses->get('class_id'))->where('subject_id', $curriculum->subject_id)->doesntExist()){
                return "Irregular";
            }
        }
        return "Regular";
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function classes()
    {
        return $this->hasMany('App\Models\ClassStudent', 'student_id');
    }
    
    public function user() {
        return $this->hasOne('App\Models\UserStudent', 'student_id');
    }

    public function getYearLevel()
    {
        $year = "";
        if(isset($this->id)){
            $year = $this->ordinal($this->year_level)." Year";
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

    public static function getOrdinalOfYearLevel($yearLevel)
    {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($yearLevel % 100) >= 11) && (($yearLevel%100) <= 13))
            return $yearLevel. 'th';
        else
            return $yearLevel. $ends[$yearLevel % 10];
    }

    public function hasClass($classID)
    {
        if(ClassStudent::where([
            ['student_id', $this->id],
            ['class_id', $classID],
        ])->exists()){
            return true;
        }
        return false;
    }

    public static function getStudentName()
	{
		$name = "N/A";
		if($this->id){
			$name = $this->first_name.' '.
				(is_null($this->middle_name) ? '' : $this->middle_name[0].'. ').
				$this->last_name;
		}
		return $name;
    }
    
    public function getName()
	{
		$name = "N/A";
		if($this->id){
			$name = $this->first_name.' '.
				((is_null($this->middle_name) || $this->middle_name=='')  ? '' : $this->middle_name[0].'. ').
				$this->last_name.
				' '.$this->suffix;
		}
		return $name;
    }

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
                    if(!is_null($this->middle_name) || $this->middle_name==''){
                        if($i == 1){
                            $name .= ' '.$this->middle_name.' ';
                        }elseif($i == 2){
                            $name .= ' '.$this->middle_name;
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
                /* case 'a':
                    if($i == 0){
                        $name .= $this->affiliation.', ';
                    }elseif($i == 2){
                        $name .= ' '.$this->affiliation;
                    }
                    break; */
                
                default:
                    $name = $this->first_name.' '.
                        ((is_null($this->middle_name) || $this->middle_name=='') ? '' : $this->middle_name[0].'. ').
                        $this->last_name.
                        (is_null($this->suffix) ? '' : ', '.$this->suffix);
                        break;
            }
        }
		
		return $name;
    }
    
    public function avatar()
    {
        $avatar = 'images/'.$this->gender.'.jpg';
        if(!is_null($this->image)){
            $avatar = 'images/student/'.$this->image;
        }
        return $avatar;
    }
}
