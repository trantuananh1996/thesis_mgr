<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Gate;

use App\Cohort;
use App\Program;
use App\User;
use App\Role;
use App\Manager\Unit;
use App\StudentCohort;

class CohortsProgramsController extends Controller
{
  	public function __construct(){

  	}

    public function config(){
        if(Gate::denies('cohorts_programs'))
            return redirect('/404');

        $cohorts = Cohort::orderBy('name')->get();

        $programs = Program::orderBy('name')->with('unit')->get();

        $units = Unit::orderBy('name')->get();

        return view('manager.cohorts-programs.config',compact('cohorts','programs','units'));
    }

  	public function index(){
        if(Gate::denies('cohorts_programs'))
            return redirect('/404');

  		$cohorts = Cohort::orderBy('name')->with('programs')->get();

  		return view('manager.cohorts-programs.index',compact('cohorts'));
  	}

  	// CRUD cohorts
    public function addCohort(Request $request)
    {
        $data = $request->all();

        $code_strtoupper['code'] = strtoupper(trim($data['code']));
        $code_strtoupper['name'] = trim($data['name']);

        $cohort_codes = Cohort::all()->pluck('code')->all();

        if (in_array($code_strtoupper['code'], $cohort_codes)) {
            return response()->json([
                'code' => 35,
                'message' => 'Trùng Code'
            ]);
        } else {
            $cohort = new Cohort;
            $cohort = $cohort->store($code_strtoupper);

            return view('manager.cohorts-programs.row-table-cohort',compact('cohort'));
        }
    }

    public function saveCohort(Request $request)
    {
        $data = $request->all();

        if (!isset($data['cohort_id'])) {
            return response()->json([
                'code' => 32,
                'message' => 'Thiếu dữ liệu gửi lên',
                'params' => $data
            ]);
        }

        $cohort = Cohort::whereId($data['cohort_id'])->first();

        if (is_null($cohort)) {
            return response()->json([
                'code' => 404,
                'message' => 'Không tìm thấy cohort',
                'params' => $data
            ]);
        }

        $cohort_codes = Cohort::whereNotIn('id', [$data['cohort_id']])->pluck('code')->all();

        $code_strtoupper['code'] = strtoupper(trim($data['code']));
        $code_strtoupper['name'] = trim($data['name']);

        if (in_array($code_strtoupper['code'], $cohort_codes)) {
            return response()->json([
                'code' => 35,
                'message' => 'Trùng Code'
            ]);
        } else {
            $cohort->update($code_strtoupper);

            return response()->json([
                'code' => 200,
                'message' => 'Cập nhật thông tin thành công',
                'data' => array(
                    'name' => $cohort->name,
                    'code' => $cohort->code
                )
            ]);
        }
    }

    public function deleteCohort(Request $request)
    {
        $data = $request->all();

        if (!isset($data['cohort_id'])) {
            return response()->json([
                'code' => 32,
                'message' => 'Thiếu dữ liệu gửi lên',
                'params' => $data
            ]);
        }
        $cohort = Cohort::whereId($data['cohort_id'])->firstOrFail();

        if (is_null($cohort)) {
            return response()->json([
                'code' => 404,
                'message' => 'Không tìm thấy cohort',
                'params' => $data
            ]);
        }

        $cohort->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Xóa thành công',
        ]);
    }


    // CRUD programs
    public function addProgram(Request $request)
    {
        $data = $request->all();

        $program_codes = Program::all()->pluck('code')->all();

        if (in_array(trim($data['code']), $program_codes)) {
            return response()->json([
                'code' => 35,
                'message' => 'Trùng Code'
            ]);
        } else {
            $program = new Program;

            $program = $program->store($data);

            $program->unit = $program->unit()->first();

            $units = Unit::orderBy('name')->get();

            return view('manager.cohorts-programs.row-table-program',compact('program','units'));
        }
    }

    public function saveProgram(Request $request)
    {
        $data = $request->all();

        if (!isset($data['program_id'])) {
            return response()->json([
                'code' => 32,
                'message' => 'Thiếu dữ liệu gửi lên',
                'params' => $data
            ]);
        }
        $program = Program::whereId($data['program_id'])->first();

        if (is_null($program)) {
            return response()->json([
                'code' => 404,
                'message' => 'Không tìm thấy quyền này',
                'params' => $data
            ]);
        }

        $program_codes = Program::whereNotIn('id', [$data['program_id']])->pluck('code')->all();

        if (in_array(trim($data['code']), $program_codes)) {
            return response()->json([
                'code' => 35,
                'message' => 'Trùng Code'
            ]);
        } else {
            $program->update($data);

            return response()->json([
                'code' => 200,
                'message' => 'Cập nhật thông tin thành công',
                'data' => array(
                    'name' => $program->name,
                    'code' => $program->code,
                    'unit_name'=> $program->unit()->first()->name
                )
            ]);
        }
    }

    public function deleteProgram(Request $request)
    {
        $data = $request->all();

        if (!isset($data['program_id'])) {
            return response()->json([
                'code' => 32,
                'message' => 'Thiếu dữ liệu gửi lên',
                'params' => $data
            ]);
        }
        $program = Program::whereId($data['program_id'])->firstOrFail();

        if(is_null($program)) {
            return response()->json([
                'code' => 404,
                'message' => 'Không tìm thấy program',
                'params' => $data
            ]);
        }

        $program->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Xóa thành công',
        ]);
    }

    /* FUNCTIONS FOR CONNECT */
    public function show_cohort_connect_programs(Request $request){
        $data = $request->all();

        if(!isset($data['cohort_id']))
            return '<div align="center">Thiếu dữ liệu gửi lên</div>';

        $cohort = Cohort::whereId($data['cohort_id'])->first();

        if(is_null($cohort))
            return '<div align="center">Không tìm thấy chức vụ này</div>';

        if(isset($data['programs_connect']) && $data['programs_connect']!= null && $data['programs_connect'] != ''){
            $data['programs_connect'] = explode(',', $data['programs_connect']);
                $cohort->programs()->attach($data['programs_connect']);
        }

        if(isset($data['programs_disconnect']) && $data['programs_disconnect']!= null && $data['programs_disconnect'] != ''){
            $data['programs_disconnect'] = explode(',', $data['programs_disconnect']);
            if($data['programs_disconnect'] != '')
                $cohort->programs()->detach($data['programs_disconnect']);
        }


        $connect_programs = $cohort->programs()->get();

        $disconnect_programs = Program::whereNotIn('id',$connect_programs->pluck('id'))->get();

        return view('manager.cohorts-programs.cohort-connect-programs',compact('cohort','connect_programs','disconnect_programs'));
    }

    // functions for connect students 
    public function cohort_students(Request $request){
        $data = $request->all();

        if(!isset($data['cohort_id']) || !isset($data['program_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $cohort_id = $data['cohort_id'];
        $program_id = $data['program_id'];

        // connect students
        if(isset($data['students_connect']) && $data['students_connect']!= null && $data['students_connect'] != ''){
            $data['students_connect'] = explode(',', $data['students_connect']);
            StudentCohort::connect_students($cohort_id,$program_id,$data['students_connect']);
        }

        // disconnect students
        if(isset($data['students_disconnect']) && $data['students_disconnect']!= null && $data['students_disconnect'] != ''){
            $data['students_disconnect'] = explode(',', $data['students_disconnect']);
            StudentCohort::disconnect_students($data['students_disconnect']);
        }

        $students_cohort = StudentCohort::all();
        $students_cohort_ids = $students_cohort->pluck('user_id')->toArray();

        $students_cohort_connect = $students_cohort->filter(
            function($student,$index) use ($data){
                return ($student->cohort_id == $data['cohort_id'] && $student->program_id == $data['program_id']);
            });
        $students_cohort_connect_ids = $students_cohort_connect->pluck('user_id')->toArray();

        $student_role = Role::whereCode('SV')->first();

        if(is_null($student_role))
            $students = collect();
        else
            $students = $student_role->users()->orderBy('first_name')->get();

        $students_connect = $students->filter(function($student,$key) use ($students_cohort_connect_ids){
            return in_array($student->id, $students_cohort_connect_ids);
        });

        $students_disconnect = $students->filter(function($student,$key) use ($students_cohort_ids){
            return !in_array($student->id, $students_cohort_ids);
        });

        return view('manager.cohorts-programs.cohort-students.connect',
                compact('students_connect','students_disconnect','cohort_id','program_id'));

    }
}
