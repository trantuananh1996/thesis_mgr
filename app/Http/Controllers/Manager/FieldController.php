<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests\FieldRequest;
use App\Manager\Field;
use App\Manager\Unit;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class FieldController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index ()
	{
		$fields = Field::with('unit')->get();

		return view('manager.field.index', compact('fields'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create ()
	{
		$units = Unit::all();

		return view('manager.field.create', compact('units'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  FieldRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store (FieldRequest $request)
	{
		$data = $request->all();
		$data['created_user_id'] = Auth::user()->id;

		Field::create($data);
		flash()->success('Thành công', 'Đã tạo lĩnh vực mới');

		return Redirect::route('field.create');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string $slug
	 * @return \Illuminate\Http\Response
	 */
	public function show ($slug)
	{
		$field = Field::findBySlug($slug)->with('unit')->first();

		if (is_null($field))
		{
			flash()->error('Lỗi', 'Không tìm thấy lĩnh vực');

			return back();
		}

		return view('manager.field.show', compact('field'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  string $slug
	 * @return \Illuminate\Http\Response
	 */
	public function edit ($slug)
	{
		$field = Field::findBySlug($slug)->with('unit')->first();
		$units = Unit::all();
		if (is_null($field))
		{
			flash()->error('Lỗi', 'Không tìm thấy lĩnh vực');

			return back();
		}

		return view('manager.field.edit', compact('field', 'units'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  FieldRequest $request
	 * @param  string $slug
	 * @return \Illuminate\Http\Response
	 */
	public function update (FieldRequest $request, $slug)
	{
		$data = $request->all();
		$data['modified_user_id'] = Auth::user()->id;

		$field = Field::findBySlug($slug);
		$field->slug = null;
		$field->update($data);

		flash()->success('Thành công', 'Đã cập nhật thông tin lĩnh vực thành công');

		return back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string $slug
	 * @return \Illuminate\Http\Response
	 */
	public function destroy ($slug)
	{
		$field = Field::findBySlug($slug);
		$name = $field->name;
		$field->delete();

		flash()->success('Thành công', 'Đã xóa lĩnh vực ' . $name);

		return Redirect::route('field.index');
	}

	/* FUNCTIONS FOR CONNECT */
	public function connectTeacher (Request $request)
	{
		$data = $request->all();

		if (!isset($data['field_id']))
		{
			return '<div align="center">Thiếu dữ liệu gửi lên</div>';
		}

		$field = Field::find($data['field_id']);

		if (is_null($field))
		{
			return '<div align="center">Không tìm thấy lĩnh vực</div>';
		}

		if (isset($data['teacher_connect']) && $data['teacher_connect'] != null && $data['teacher_connect'] != '')
		{
			$data['teacher_connect'] = explode(',', $data['teacher_connect']);
			$data['created_user_id'] = Auth::user()->id;
			$field->teachers()->attach($data['teacher_connect'], ['created_user_id' => Auth::user()->id]);
		}

		if (isset($data['teacher_disconnect']) && $data['teacher_disconnect'] != null && $data['teacher_disconnect'] != '')
		{
			$data['teacher_disconnect'] = explode(',', $data['teacher_disconnect']);
			if ($data['teacher_disconnect'] != '')
			{
				$field->teachers()->detach($data['teacher_disconnect'], ['created_user_id' => Auth::user()->id]);
			}
		}

		$teachers_connect = $field->teachers()->get();
		$teachers_disconnect = User::join('role_user as ru', 'users.id', '=', 'ru.user_id')
			->join('roles as r', 'r.id', '=', 'ru.role_id')
			->where('users.status', '=', 1)
			->where('r.code', '=', 'GV')
			->whereIn('users.id', function ($query) use ($field)
			{
				$query->select('user_id')->from('teacher_unit')->where('unit_id', '=', $field->unit_id);
			})
			->whereNotIn('users.id', function ($query) use ($field)
			{
				$query->select('user_id')->from('teacher_field')->where('field_id', '=', $field->id);
			})
			->select('users.*')->get();

		return view('manager.field.teacher-connect-field', compact('teachers_connect', 'teachers_disconnect', 'field'));
	}
}
