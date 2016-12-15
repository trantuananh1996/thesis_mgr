<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class StudentCohort extends Model
{
    protected $table = 'student_cohort_program';

    protected $fillable = [
    	'user_id',
    	'cohort_id',
    	'program_id'
    ];

    public function student(){
    	return $this->hasOne(\App\User::class, 'id', 'user_id');
    }

    public function cohort(){
    	return $this->hasOne(\App\Cohort::class, 'id', 'cohort_id');	
    }

    public function program(){
    	return $this->hasOne(\App\Program::class, 'id', 'program_id');		
    }

    public static function connect_students($cohort_id,$program_id,$student_ids){
        $students_cohort = DB::table('student_cohort_program')->whereIn('user_id',$student_ids)->delete();
        
        $array_create = array();

        foreach($student_ids as $student_id){
            $new_student_cohort = array(
                    'cohort_id'=>$cohort_id,
                    'program_id'=>$program_id,
                    'user_id'=>$student_id,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now()
                );
            array_push($array_create,$new_student_cohort);
        }
        
        DB::table('student_cohort_program')->insert($array_create);
    }

    public static function disconnect_students($student_ids){
        $students_cohort = DB::table('student_cohort_program')->whereIn('user_id',$student_ids)->delete();

        return true;
    }
}
