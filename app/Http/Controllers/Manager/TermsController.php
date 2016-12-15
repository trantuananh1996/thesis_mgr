<?php

namespace App\Http\Controllers\Manager;

use App\StudentThesisEmail;
use App\StudentTopic;
use App\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;
use App\Term;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;


class TermsController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        if (Gate::denies('term_manage')) {
            return redirect('/404');
        }

        $terms = Term::orderBy('start_date')->get();

        return view('manager.terms.index', compact('terms'));
    }

    public function create(Request $request)
    {
        $data = $request->all();

        /* validate data */
        if (!isset($data['name'])) {
            return response_error(32, 'Cần phải nhập tên', $data);
        }

        if (!isset($data['start_date']) || !isset($data['end_date'])) {
            return response_error(32, 'Cần phải nhập ngày bắt đầu và kết thúc', $data);
        }

        $data['start_date'] = Carbon::parse($data['start_date']);
        $data['end_date'] = Carbon::parse($data['end_date']);
        $now = Carbon::now()->toDay();
        if ($data['start_date'] < $now) {
            return response_error(32, 'Ngày bắt đầu không được nằm trong quá khứ', $data);
        } else {
            if ($data['start_date'] > $data['end_date']) {
                return response_error(32, 'Ngày bắt đầu không được lớn hơn ngày kết thúc', $data);
            }
        }

        $term = Term::whereBetween('start_date', [$data['start_date'], $data['end_date']])->first();
        if (!is_null($term)) {
            return response_error(32, 'Đã có đợt đăng ký trong khoảng thời gian này', $data);
        }

        $term = Term::whereBetween('end_date', [$data['start_date'], $data['end_date']])->first();
        if (!is_null($term)) {
            return response_error(32, 'Đã có đợt đăng ký trong khoảng thời gian này', $data);
        }

        /*end validate*/
        $data['log'] = json_encode(array());
        $data['code'] = $this->createTermCode();
//        dd($data);
        $term = Term::create($data);

        return view('manager.terms.term-row', compact('term'));

    }

    public function update(Request $request)
    {
        $data = $request->all();

        /* validate data */
        if (!isset($data['term_id'])) {
            return response_error(32, 'Thiếu dữ liệu gửi lên', $data);
        }

        $term = Term::whereId($data['term_id'])->first();
        if (is_null($term)) {
            return response_error(404, 'Không tìm thấy đợt đăng ký này', $data);
        }

        if (!isset($data['name'])) {
            return response_error(32, 'Cần phải nhập tên', $data);
        }

        if (!isset($data['start_date']) || !isset($data['end_date'])) {
            return response_error(32, 'Cần phải nhập ngày bắt đầu và kết thúc', $data);
        }

        $data['start_date'] = Carbon::parse($data['start_date']);
        $data['end_date'] = Carbon::parse($data['end_date']);
        $now = Carbon::now()->toDay();
        if ($data['start_date'] < $now) {
            return response_error(32, 'Ngày bắt đầu không được nằm trong quá khứ', $data);
        } else {
            if ($data['start_date'] > $data['end_date']) {
                return response_error(32, 'Ngày bắt đầu không được lớn hơn ngày kết thúc', $data);
            }
        }

        $duplicate_term = Term::whereBetween('start_date', [$data['start_date'], $data['end_date']])->first();
        if (!is_null($duplicate_term) && $term->id != $duplicate_term->id) {
            return response_error(32, 'Đã có đợt đăng ký trong khoảng thời gian này', $data);
        }

        $duplicate_term = Term::whereBetween('end_date', [$data['start_date'], $data['end_date']])->first();
        if (!is_null($duplicate_term) && $term->id != $duplicate_term->id) {
            return response_error(32, 'Đã có đợt đăng ký trong khoảng thời gian này', $data);
        }

        /*end validate*/
        $term->update($data);
        $data['start_date'] = $data['start_date']->format('d-m-Y');
        $data['end_date'] = $data['end_date']->format('d-m-Y');

        return response_success('Cập nhật thông tin thành công', $data);

    }

    public function delete(Request $request)
    {
        $data = $request->all();

        /* validate data */
        if (!isset($data['term_id'])) {
            return response_error(32, 'Thiếu dữ liệu gửi lên', $data);
        }

        $term = Term::whereId($data['term_id'])->first();
        if (is_null($term)) {
            return response_error(404, 'Không tìm thấy đợt đăng ký này', $data);
        }

        /* end validate*/
        $term->delete();

        return response_success('Xóa đợt đăng ký thành công', $data);
    }

    public function createTermCode()
    {
        $term = DB::table('terms')->where('id', DB::raw("(select max(`id`) as max from terms)"))->first();
        if (is_null($term)) {
            $term_id = 0;
        } else {
            $term_id = $term->id;
        }
        if ($term_id < 10) {
            $code = 'TERM00' . ($term_id + 1);
        } else {
            if ($term_id > 10 && $term < 100) {
                $code = 'TERM0' . ($term_id + 1);
            } else {
                $code = 'TERM' . ($term_id + 1);
            }
        }

        return $code;
    }

    public function show($code)
    {
        $term = Term::where('code', '=', $code)->first();
        $students = User::whereIn('id', json_decode($term->log))->with('student_cohort', 'student_cohort.cohort',
            'student_cohort.program')->get();
        $students = $this->processStudentList($students);
        if (is_null($term)) {
            flash()->error('Lỗi', 'Không tìm thấy đợt đăng ký');

            return Redirect::route('terms');
        }
        $templateUrl = '/files/templates/template-upload-term-students.xlsx';

        return view('manager.terms.show', compact('term', 'templateUrl', 'students'));
    }

    public function validateUpload(Request $request)
    {
        $term = Term::where('id', '=', $request->get('term_id'))->first();
        if (!Input::hasFile('upload')) {
            flash()->overlay('Lỗi', 'Vui lòng chọn tệp tin Excel chứa thông tin sinh viên', 'error');

            return Redirect::route('terms.show', [$term->code]);
        }

        $file = Input::file('upload');
        $name = time() . '-' . $file->getClientOriginalName();

        $file = $file->move(public_path() . '/files/import/terms', $name);
        $file_type = pathinfo($file, PATHINFO_EXTENSION);

        // Validate file extension
        if ($file_type != 'xls' && $file_type != 'xlsx') {
            flash()->overlay('Lỗi', 'Vui lòng chọn tệp tin có định dạng Excel (có đuôi .xls hoặc .xlsx', 'error');

            return Redirect::route('terms.show', [$term->code]);
        }
        //Get results
        $results = Excel::load($file, function ($reader) {
            $reader->formatDates(false);
        })->get();

        //Check number of rows to prevent default template
        if (count($results) == 1) {
            flash()->overlay('Lỗi', 'Vui lòng nhập thông tin của sinh viên', 'error');

            return Redirect::route('terms.show', [$term->code]);
        }

        $errors = array(); //Array to save errors
        $array_key = [
            'student_code',
            'name',
            'dob',
            'cohort_id',
            'program_id',
        ]; //template header keys
        $db_student_code = User::join('role_user as ru', 'users.id', '=', 'ru.user_id')
            ->join('roles as r', 'ru.role_id', '=', 'r.id')
            ->where('r.code', '=', 'SV')
            ->select('users.username')->get()->pluck('username')->all();
        $student_code = array_column($results->toArray(), 'student_code');
        if (count(array_unique($student_code)) < count($student_code)) {
            flash()->overlay('Lỗi', 'Tệp tin tải lên có mã sinh viên trùng nhau. Vui lòng kiểm tra lại thông tin',
                'error');

            return Redirect::route('terms.show', [$term->code]);
        }

        foreach ($results as $index => $result) {
            $check_keys = array();
            if ($index == 0) {
                //Validate header keys
                foreach (array_keys($result->toArray()) as $key_name) {
                    $check_keys[] = $key_name;
                }
                if (count(array_diff($check_keys, $array_key)) != 0) {
                    flash()->overlay('Lỗi', 'Vui lòng tải đúng tệp tin theo mẫu qui định', 'error');

                    return Redirect::route('terms.show', [$term->code]);
                }
            } else {
                if (!in_array($result['student_code'], $db_student_code)) {
                    $errors[] = 'Mã sinh viên tại dòng ' . ($index + 2) . ' không tồn tại';
                }
            }
        }

        if (count($errors) > 0) {
            return Redirect::route('terms.show', [$term->code])->withErrors($errors);
        }
        //remove keys row then get student code
        unset($results[0]);
        $student_ids = User::whereIn('username',
            array_column($results->toArray(), 'student_code'))->pluck('users.id')->all();
        $term->log = json_encode($student_ids);
        $term->save();
        $student_topics = StudentTopic::whereIn('student_id', $student_ids)->get();
        foreach ($student_topics as $topic) {
            $topic->can_register = 1;
            $topic->save();
        }
        flash()->success('Thành công', 'Đã cập nhật danh sách sinh viên đủ điều kiện đăng ký đề tài');

        return Redirect::route('terms.show', [$term->code]);
    }

    /**
     * @param $students
     * @return mixed
     */
    protected function processStudentList($students)
    {
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

//            $students = $students->sortBy(function ($student, $index) {
//                return $student->cohort_name;
//            })->sortBy(function ($student, $index) {
//                return $student->program_name;
//            });
        }

        return $students;
    }

    public function showConnectStudents(Request $request)
    {
        $data = $request->all();

        if (!isset($data['term_id'])) {
            return '<div align="center">Thiếu dữ liệu gửi lên</div>';
        }

        $term = Term::find($data['term_id']);

        if (is_null($term)) {
            return '<div align="center">Không tìm thấy đợt đăng ký</div>';
        }
        $student_ids = json_decode($term->log);
        if (isset($data['student_connect']) && $data['student_connect'] != null && $data['student_connect'] != '') {
            $data['student_connect'] = explode(',', $data['student_connect']);
            $student_ids = array_merge($student_ids, $data['student_connect']);
        }

        if (isset($data['student_disconnect']) && $data['student_disconnect'] != null && $data['student_disconnect'] != '') {

            $data['student_disconnect'] = explode(',', $data['student_disconnect']);
            $student_ids = array_values(array_diff($student_ids, $data['student_disconnect']));
        }
        $term->log = json_encode($student_ids);
        $term->save();
        $student_ids = json_decode($term->log);
        $students_connect = User::whereIn('id', $student_ids)->get();
        $students_disconnect = User::join('role_user as ru', 'users.id', '=', 'ru.user_id')
            ->join('roles as r', 'r.id', '=', 'ru.role_id')
            ->where('r.code', '=', 'SV')
            ->where('users.status', '=', 1)
            ->whereNotIn('users.id', $student_ids)
            ->select('users.*')
            ->get();

        return view('manager.terms.student-connect-term', compact('students_connect', 'students_disconnect', 'term'));
    }

    public function reloadConnectStudents(Request $request)
    {
        $term = Term::find($request->get('term_id'));
        $students = User::whereIn('id', json_decode($term->log))->with('student_cohort', 'student_cohort.cohort',
            'student_cohort.program')->get();
        $students = $this->processStudentList($students);

        return view('manager.terms.student-list', compact('students'));
    }

    public function sendEmailToStudents(Request $request)
    {
        $term = Term::where('id', '=', $request->get('term_id'))->first();

        if (is_null($term)) {
            return 2;
        }

        $student_ids = json_decode($term->log);
        if (count($student_ids) == 0) {
            return 3;
        }

        foreach ($student_ids as $id) {
            StudentThesisEmail::create(array(
                'student_id' => $id,
                'term_id'    => $term->id,
                'type'       => 1,
                'status'     => 0
            ));
        }

        return 1;
    }
}
