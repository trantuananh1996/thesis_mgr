<?php

namespace App\Http\Controllers\Manager\Users;

use App\Manager\Unit;
use App\UserEmailPassword;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;
use Carbon\Carbon;
use Gate;

use Auth;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use Validator;

/**
 * Class TeachersController
 * @package App\Http\Controllers\Manager\Users
 */
class TeachersController extends Controller
{

    /**
     * @var string
     */
    protected $templateUrl;

    /**
     * TeachersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->templateUrl = '/files/templates/template-upload-teachers.xlsx';
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {

        if (Gate::denies('users_manage')) {
            return redirect('/404');
        }

        $role = Role::whereCode('GV')->first();

        if (!is_null($role)) {
            $teachers = $role->users()->get();
        } else {
            $teachers = collect();
        }
        $templateUrl = $this->templateUrl;

        return view('manager.users.teachers.index', compact('teachers', 'templateUrl'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
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

        return view('manager.users.teachers.teacher-row', ['teacher' => $user, 'action' => 'create']);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
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

        return view('manager.users.teachers.edit', ['teacher' => $user]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
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

        return view('manager.users.teachers.teacher-row', ['teacher' => $user, 'action' => 'edit']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
        //Validate input file
        if (!Input::hasFile('upload')) {
            flash()->overlay('Lỗi', 'Vui lòng chọn tệp tin Excel chứa thông tin giảng viên', 'error');

            return Redirect::route('teachers');
        }

        $file = Input::file('upload');
        $name = time() . '-' . $file->getClientOriginalName();

        $file = $file->move(public_path() . '/files/import/teachers', $name);
        $file_type = pathinfo($file, PATHINFO_EXTENSION);

        // Validate file extension
        if ($file_type != 'xls' && $file_type != 'xlsx') {
            flash()->overlay('Lỗi', 'Vui lòng chọn tệp tin có định dạng Excel (có đuôi .xls hoặc .xlsx', 'error');

            return Redirect::route('teachers');
        }
        //Get results
        $results = Excel::load($file, function ($reader) {
            $reader->formatDates(false);
        })->get();

        //Check number of rows to prevent default template
        if (count($results) == 1) {
            flash()->overlay('Lỗi', 'Vui lòng nhập thông tin của giảng viên', 'error');

            return Redirect::route('teachers');
        }

        //VALIDATE UPLOAD DATA
        $errors = array(); //Array to save errors
        $data = array(); //Array to save teachers's data;
        $array_key = [
            'unit_code',
            'code',
            'username',
            'email',
            'full_name',
            'gender',
            'phone',
            'dob'
        ]; //template header keys
        //Validate duplicate username & email in uploaded file
        $username = array_column($results->toArray(), 'username');
        if (count(array_unique($username)) < count($username)) {
            flash()->overlay('Lỗi', 'Tệp tin tải lên có mã cán bộ trùng nhau. Vui lòng kiểm tra lại thông tin',
                'error');

            return Redirect::route('teachers');
        }
        $email = array_column($results->toArray(), 'email');
        if (count(array_unique($email)) < count($email)) {
            flash()->overlay('Lỗi', 'Tệp tin tải lên có email trùng nhau. Vui lòng kiểm tra lại thông tin',
                'error');

            return Redirect::route('teachers');
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

                    return Redirect::route('teachers');
                }
            } else {
                $check = $this->validateUploadData($result, $index);
                if (count($check) != 0) {
                    $errors = array_values(array_merge($errors, $check));
                }
            }
        }

        if (count($errors) > 0) {
            return Redirect::route('teachers')->withErrors($errors);
        }

        $commit = $this->commitUploadTeachers($results);
        if ($commit != 1) {
            flash()->overlay('Lỗi', 'Có lỗi xảy ra trong quá trình tạo giảng viên:' . $commit, 'error');

            return Redirect::route('teachers');
        }

        flash()->success('Thành công', 'Đã khởi tạo thông tin giảng viên thành công');

        return Redirect::route('teachers');
    }


    /**
     * @param $result
     * @param $index
     * @return array
     */
    protected function validateUploadData($result, $index)
    {
        $unit_code = Unit::all()->pluck('code')->toArray(); //Array of exists units's code
        $db_email = User::all()->pluck('email')->toArray(); //Array of exists email
        $errors = array(); //Array to save errors
        $row = $index + 2;
        if (!in_array($result['unit_code'], $unit_code)) {
            $errors[] = 'Mã đơn vị tại dòng ' . $row . ' không hợp lệ';
        }
        $checkName = $this->checkName($result['full_name'], $row);
        if ($checkName != '') {
            $errors[] = $checkName;
        }
        $checkGender = $this->checkGender($result['gender'], $row);
        if ($checkGender != '') {
            $errors[] = $checkGender;
        }
        $checkEmail = $this->checkEmail($result['email'], $row, $db_email);
        if ($checkEmail != '') {
            $errors[] = $checkEmail;
        }
        if (!is_null($result['dob']) && $this->checkDate($result['dob'], $row) != '') {
            $errors[] = $this->checkDate($result['dob'], $row);
        }

        return $errors;

    }

    /**
     * @param $results
     * @return int|string
     */
    public function commitUploadTeachers($results)
    {
        DB::beginTransaction();
        try {
            foreach ($results as $index => $result) {
                if ($index == 0) {
                    continue;
                }
                $name = analys_name($result['full_name']);
                $date = is_null($result['dob']) ?
                    Carbon::createFromFormat('Y-m-d', '1980-01-01') : Carbon::createFromFormat('d-m-y', $result['dob']);
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
                //Assign role for user
                $user->assignRole('GV');
                //Add user to unit
                $unit = Unit::where('code', '=', $result['unit_code'])->first();

                $unit->teachers()->attach([$user->id],
                    ['created_user_id' => Auth::user()->id, 'created_at' => Carbon::now()]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }

        DB::commit();

        return 1;
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
     * @param $db_email
     * @return string
     */
    public function checkEmail($email, $row, $db_email)
    {
        $errors = '';
        if ($email == '' || is_null($email)) {
            return 'Thiếu thông tin email tại dòng ' . $row;
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 'Định dạng email sai tại dòng ' . $row;
            } else {
                if (in_array($email, $db_email)) {
                    return 'Email đã tồn tại trong hệ thống tại dòng ' . $row;
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
}
