<?php

namespace App\Http\Controllers;

use App\Manager\Unit;
use App\StudentTopic;
use App\Topic;
use Illuminate\Http\Request;
use Hash;
use Auth;
use JavaScript;
use Session;
use Validator;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('SV')) {
            $student = Auth::user();

            $student->cohort = $student->student_cohort()->with('program')->first();

            if (is_null($student->student_cohort)) {
                $topics = collect();
                $fields = collect();
                $unit_name = '';
            } elseif (is_null($student->student_cohort->program)) {
                $topics = collect();
                $fields = collect();
                $unit_name = '';
            } else {
                $program = $student->student_cohort->program;
                $unit = Unit::whereId($program->unit_id)->with('fields.topics')->first();
                $unit_name = $unit->name;
                if (empty($unit->fields)) {
                    $topics = collect();
                    $fields = collect();
                } else {
                    $field_ids = $unit->fields->pluck('id')->toArray();
                    $topics = Topic::whereIn('field_id', $field_ids)->with('author', 'field', 'students_learn',
                        'students_register', 'tutors')->orderBy('updated_at', 'DESC')->orderBy('name')->get();
                    $fields = $unit->fields;
                }
            }

            $student->topic = $student->topic()
                ->with('current_topic', 'current_topic.author', 'current_topic.field', 'current_topic.students_learn',
                    'current_topic.students_register', 'current_topic.tutors')
                ->with('register_topic', 'register_topic.author', 'register_topic.field',
                    'register_topic.students_learn', 'register_topic.students_register',
                    'register_topic.tutors')->first();

            if (is_null($student->topic)) {
                $student->topic = StudentTopic::create_empty($student->id);
            }
            $json_fields = $this->createJsonFields($fields);
            JavaScript::put([
                'json' => $json_fields
            ]);

            return view('home', compact('topics', 'unit_name', 'student', 'fields', 'json_fields'));
        }

        return view('home');
    }

    public function show_profile()
    {
        $user = Auth::user();

        return view('pages.profile', compact('user'));
    }

    public function update_profile(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'password'              => 'min:6|confirmed',
            'password_confirmation' => 'same:password',
            'dob'                   => 'required',
            'gender'                => 'numeric|required',
            'fullName'              => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors($validator)->withInput();
        }

        if (isset($data['password']) && $data['password'] != '') {
            if (!isset($data['old_password'])) {
                return redirect(redirect()->getUrlGenerator()->previous())->withErrors('Chưa nhập mật khẩu cũ.')->withInput();
            }

            if (!Hash::check($data['old_password'], Auth::user()->password)) {
                return redirect(redirect()->getUrlGenerator()->previous())->withErrors('Mật khẩu cũ chưa chính xác.')->withInput();
            }
        }

        Auth::user()->updateProfile($data);

        Session::flash('message', 'Cập nhật thông tin thành công');

        return redirect('/profile');
    }

    public function createJsonFields($fields)
    {
        $data = array();

        foreach ($fields as $field) {
            $current = array();
            $current['name'] = $field->name;
            $current['type'] = 'folder';
            $current['id'] = 'field_' . $field->id;
            $current['data'] = array();
            if (count($field->topics) > 0) {
                foreach ($field->topics as $topic) {
                    $current['data'][] = (object)[
                        'name' => $topic->name,
                        'type' => 'item',
                        'id'   => 'topic_' . $topic->id
                    ];
                }
            }
            else
            {
                $current['data'][] = (object)[
                    'name' => 'Hiện chưa có chủ đề nào cho lĩnh vực này',
                    'type' => 'item',
                    'id'   => 'no_topic_' . $field->id
                ];
            }

            $data[] = (object)$current;
        }

        return json_encode(array_values($data));
    }
}
