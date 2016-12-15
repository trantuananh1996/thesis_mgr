<?php

namespace App\Http\Controllers\Manager\Users;

use App\StudentTopic;
use App\UserEmailPassword;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;
use App\StudentCohort;
use App\Cohort;
use App\Program;

use Carbon\Carbon;
use Gate;

use Auth;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use Validator;


class StudentsController extends Controller
{

    protected $cohort;
    protected $program;
    protected $program_code;
    protected $cohort_code;
    protected $username;
    protected $validator;
    protected $email;

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        if (Gate::denies('users_manage')) {
            return redirect('/404');
        }

        $role = Role::whereCode('SV')->first();

        if (!is_null($role)) {
            $students = $role->users()->with('student_cohort', 'student_cohort.cohort',
                'student_cohort.program')->get();
            foreach ($students as $student) {
                if ($student->student_cohort != null) {
                    $student->cohort = $student->student_cohort->cohort;
                    if ($student->cohort != null) {
                        $student->cohort_name = $student->cohort->name;
                    } else {
                        $student->cohort_name = '';
                    }

                    $student->program = $student->student_cohort->program;
                    if ($student->program != null) {
                        $student->program_name = $student->program->name;
                    } else {
                        $student->program_name = '';
                    }
                } else {
                    $student->cohort_name = '';
                    $student->program_name = '';
                }

                $students = $students->sortBy(function ($student, $index) {
                    return $student->cohort_name;
                })->sortBy(function ($student, $index) {
                    return $student->program_name;
                });
            }
        } else {
            $students = collect();
        }

        // cohorts programs for create form
        $cohorts_programs = Cohort::with('programs')->orderBy('cohorts.name')->get();
        $templateUrl = '/files/templates/template-upload-students.xlsx';

        return view('manager.users.students.index', compact('students', 'cohorts_programs', 'templateUrl'));
    }

    public function create(Request $request)
    {
        $data = $request->all();

        if (Gate::denies('users_act')) {
            return reponse_error(403, 'Không thao tác được hành động này', $data);
        }

        $validator = Validator::make($data, [
            'username'              => 'required|max:50',
            'email'                 => 'required|email|max:255|unique:users',
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'dob'                   => 'required',
            'fullName'              => 'required',
            'role'                  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'    => 32,
                'message' => 'Dữ liệu gửi lên không chính xác',
                'params'  => $data
            ]);
        }

        $fullName = analys_name($data['fullName']);
        $data['first_name'] = $fullName['first_name'];
        $data['middle_name'] = $fullName['middle_name'];
        $data['last_name'] = $fullName['last_name'];
        $data['dob'] = Carbon::parse($data['dob']);
        $data['status'] = 0;

        $user = new User;
        $user = $user->store_ajax($data);

        if (isset($data['cohorts_programs']) && $data['cohorts_programs'] != '0,0') {
            $ids = explode(',', $data['cohorts_programs']);
            // $ids[0]: cohort_id
            // $ids[1]: program_id
            StudentCohort::connect_students($ids[0], $ids[1], [$user->id]);
        }

        $user->student_cohort = $user->student_cohort()->first();
        $user->cohort = $user->student_cohort->cohort;
        if ($user->cohort != null) {
            $user->cohort_name = $user->cohort->name;
        } else {
            $user->cohort_name = '';
        }

        $user->program = $user->student_cohort->program;
        if ($user->program != null) {
            $user->program_name = $user->program->name;
        } else {
            $user->program_name = '';
        }

        return view('manager.users.students.student-row', ['student' => $user, 'action' => 'create']);

    }

    public function edit(Request $request)
    {
        $data = $request->all();

        if (Gate::denies('users_act')) {
            return reponse_error(403, 'Không thao tác được hành động này', $data);
        }

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return html_alert('danger', 'Thiếu dữ liệu gửi lên');
        }

        $user = User::whereId($data['user_id'])->first();
        if (is_null($user)) {
            return html_alert('danger', 'Không tìm thấy người dùng này');
        }

        return view('manager.users.students.edit', ['student' => $user]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        if (Gate::denies('users_act')) {
            return reponse_error(403, 'Không thao tác được hành động này', $data);
        }

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'    => 32,
                'message' => 'Dữ liệu gửi lên không chính xác',
                'params'  => $data
            ]);
        }

        $user = User::whereId($data['user_id'])->first();
        if (is_null($user)) {
            return response()->json([
                'code'    => 404,
                'message' => 'Không tìm thấy người dùng',
                'params'  => $data
            ]);
        }

        $user->updateProfileAjax($data);

        return view('manager.users.students.student-row', ['student' => $user, 'action' => 'edit']);
    }

    public function delete(Request $request)
    {
        $data = $request->all();

        if (Gate::denies('users_act')) {
            return reponse_error(403, 'Không thao tác được hành động này', $data);
        }

        $validator = Validator::make($data, [
            'user_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'    => 32,
                'message' => 'Dữ liệu gửi lên không chính xác',
                'params'  => $data
            ]);
        }

        $user = User::whereId($data['user_id'])->first();
        if (is_null($user)) {
            return response()->json([
                'code'    => 404,
                'message' => 'Không tìm thấy người dùng',
                'params'  => $data
            ]);
        }

        $user->deleteUser();

        return response()->json([
            'code'    => 200,
            'message' => 'Xóa người dùng thành công',
            'params'  => $data
        ]);
    }


    /**
     * Functions for upload teachers
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validateUpload(Request $request)
    {
        $this->cohort = Cohort::with('programs')->get();
        $this->program = Program::all();
        $this->program_code = $this->program->pluck('code')->toArray();
        $this->cohort_code = $this->cohort->pluck('code')->toArray();
        $users = User::all();
        $this->username = $users->pluck('username')->toArray();
        $this->email = $users->pluck('email')->toArray();
        //Validate input file
        if (!Input::hasFile('upload')) {
            flash()->overlay('Lỗi', 'Vui lòng chọn tệp tin Excel chứa thông tin sinh viên', 'error');

            return Redirect::route('students');
        }

        $file = Input::file('upload');
        $name = time() . '-' . $file->getClientOriginalName();

        $file = $file->move(public_path() . '/files/import/students', $name);
        $file_type = pathinfo($file, PATHINFO_EXTENSION);

        // Validate file extension
        if ($file_type != 'xls' && $file_type != 'xlsx') {
            flash()->overlay('Lỗi', 'Vui lòng chọn tệp tin có định dạng Excel (có đuôi .xls hoặc .xlsx', 'error');

            return Redirect::route('students');
        }
        //Get results
        $results = Excel::load($file, function ($reader) {
            $reader->formatDates(false);
        })->get();

        //Check number of rows to prevent default template
        if (count($results) == 1) {
            flash()->overlay('Lỗi', 'Vui lòng nhập thông tin của sinh viên', 'error');

            return Redirect::route('students');
        }

        //VALIDATE UPLOAD DATA
        $errors = array(); //Array to save errors
        $data = array(); //Array to save teachers's data;
        $array_key = [
            'cohort_code',
            'program_code',
            'username',
            'full_name',
            'email',
            'gender',
            'dob',
            'phone'
        ]; //template header keys

        $username = array_column($results->toArray(), 'username');
        if (count(array_unique($username)) < count($username)) {
            flash()->overlay('Lỗi', 'Tệp tin tải lên có mã sinh viên trùng nhau. Vui lòng kiểm tra lại thông tin',
                'error');

            return Redirect::route('students');
        }
        $email = array_column($results->toArray(), 'email');
        if (count(array_unique($email)) < count($email)) {
            flash()->overlay('Lỗi', 'Tệp tin tải lên có email trùng nhau. Vui lòng kiểm tra lại thông tin',
                'error');

            return Redirect::route('students');
        }

        foreach ($results as $index => $result) {


            $check_keys = array();
            if ($index == 0) {
                //Validate header keys
                foreach (array_keys($result->toArray()) as $key_name) {
                    $check_keys[] = $key_name;
                }
                if (count(array_diff($check_keys, $array_key)) != 0) {
                    flash()->overlay('Lỗi', 'Vui lòng tải đúng tệp tin theo mẫu qui định');

                    return Redirect::route('students');
                }
            } else {
                $check = $this->validateUploadData($result, $index);
                if (count($check) != 0) {
                    $errors = array_values(array_merge($errors, $check));
                }
            }
        }

        if (count($errors) > 0) {
            return Redirect::route('students')->withErrors($errors);
        }

        $commit = $this->commitUploadStudents($results);
        if ($commit != 1) {

            flash()->overlay('Lỗi', 'Có lỗi xảy ra trong quá trình tạo sinh viên:' . $commit, 'error');

            return Redirect::route('students');
        }

        flash()->success('Thành công', 'Đã khởi tạo thông tin sinh viên thành công');

        return Redirect::route('students');
    }

    public function validateUploadData($result, $index)
    {
        $errors = array(); //Array to save errors
        $row = $index + 2;
        $flagCohort = 1;
        if (!is_null($result['cohort_code']) && !in_array($result['cohort_code'], $this->cohort_code)) {
            $flagCohort = 0;
            $errors[] = 'Mã khóa học tại dòng ' . $row . ' không tồn tại';
        }

        if (!is_null($result['program_code']) && !in_array($result['program_code'], $this->program_code)) {
            $flagCohort = 0;
            $errors[] = 'Mã chương trình đào tạo tại dòng ' . $row . ' không tồn tại';
        }

        if (!is_null($result['cohort_code']) && !is_null($result['program_code']) && $flagCohort == 1) {
            if (!$this->checkCohortProgram($result['cohort_code'], $result['program_code'], $row)) {
                $errors[] = 'Chương trình đào tạo không thuộc khóa học tại dòng ' . $row;
            }
        }

        if (in_array($result['username'], $this->username)) {
            $errors[] = 'Mã sinh viên đã tồn tại ở dòng ' . $row ;
        }
        $checkName = $this->checkName($result['full_name'], $row);
        if ($checkName != '') {
            $errors[] = $checkName;
        }

        $checkGender = $this->checkGender($result['gender'], $row);
        if ($checkGender != '') {
            $errors[] = $checkGender;
        }
        $checkEmail = $this->checkEmail($result['email'], $row);
        if ($checkEmail != '') {
            $errors[] = $checkEmail;
        }
        $checkDate = $this->checkDate($result['dob'], $row);
        if ($checkDate != '') {
            $errors[] = $checkDate;
        }

        return $errors;
    }

    public function checkCohortProgram($cohort_code, $program_code, $row)
    {
        $cohort = $this->cohort->where('code', '=', $cohort_code)->first();
        $code = $cohort->programs->pluck('code')->toArray();
        if (!in_array($program_code, $code)) {
            return false;
        }

        return true;
    }


    /**
     * @param $value
     * @param $row
     * @return string
     */
    public function checkName($value, $row)
    {
        $error = '';
        if ($value == "" || is_null($value)) {
            $error = "Thiếu tên tại dòng " . $row;

            return $error;
        }
        if (count(explode(" ", $value)) <= 1) {
            $error = "Tên tại dòng " . $row . " thiếu họ hoặc tên";
        }

        return $error;
    }

    /**
     * @param $value
     * @param $row
     * @return string
     */
    public function checkGender($value, $row)
    {
        $error = '';
        if ($value == '') {
            $error = "Thiếu thông tin giới tính ở hàng " . $row;

            return $error;
        }
        if ($value != "Nam" && $value != "Nữ" && $value != "nam" && $value != "nữ") {
            $error = "Giới tính ở dòng " . $row . " điền sai giá trị";
        }

        return $error;
    }

    /**
     * @param $email
     * @param $row
     * @return string
     */
    public function checkEmail($email, $row)
    {
        $errors = '';
        if ($email == '' || is_null($email)) {
            return 'Thiếu thông tin email tại dòng ' . $row;
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 'Định dạng email sai tại dòng ' . $row;
            } else {
                if (in_array($email, $this->email)) {
                    return 'Email đã tồn tại ở dòng ' . $row;
                }
            }
        }

        return $errors;
    }

    /**
     * @param $date
     * @param $row
     * @return string
     */
    public function checkDate($date, $row)
    {

        $errors = '';
        if (is_null($date)) {
            return 'Thiếu ngày sinh tại dòng ' . $row;
        }
        try {
            $date = Carbon::createFromFormat('d/m/Y', $date);
        } catch (InvalidArgumentException $x) {
            $errors = 'Định dạng ngày sinh sai giá trị tại dòng ' . $row;
        }

        return $errors;
    }

    public function commitUploadStudents($results)
    {
        DB::beginTransaction();
        try {
            foreach ($results as $index => $result) {
                if ($index == 0) {
                    continue;
                }
                $name = analys_name($result['full_name']);
                $date = is_null($result['dob']) ?
                    Carbon::createFromFormat('Y-m-d', '1980-01-01') : Carbon::createFromFormat('d/m/Y', $result['dob']);
                $gender = ($result['gender'] == "Nam" || $results['gender']  == "nam") ? 0 : 1;
                $phone = is_null($result['phone']) ? '' : $result['phone'];
                $password = str_random(6);
                //Create user
                $data = [
                    'email'       => $result['email'],
                    'first_name'  => $name['first_name'],
                    'middle_name' => $name['middle_name'],
                    'last_name'   => $name['last_name'],
                    'phone'       => $phone,
                    'address'     => '',
                    'dob'         => $date,
                    'username'    => $result['username'],
                    'avatar'      => 'avatar/NOIMAGE.jpg',
                    'gender'      => $gender,
                    'password'    => bcrypt($password),
                    'status'      => 0
                ];

                $user = User::create($data);

                //Create cronjob to send password to user
                UserEmailPassword::create([
                    'user_id'  => $user->id,
                    'password' => encrypt($password),
                    'status'   => 0
                ]);
                //Assign role for students
                $user->assignRole('SV');
                //Add student to cohort-program
                if (!is_null($result['cohort_code']) && !is_null($result['program_code'])) {
                    $cohort = $this->cohort->where('code', '=', $result['cohort_code'])->first();
                    $program = $this->program->where('code', '=', $result['program_code'])->first();
                    StudentCohort::connect_students($cohort->id, $program->id, [$user->id]);
                }
                //Create student topic
                StudentTopic::create_empty($user->id);

            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

        DB::commit();

        return 1;
    }
}
