<?php

namespace App\Http\Controllers\Manager;

use App\Http\Requests\Manager\UnitRequest;
use App\Manager\Unit;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect;

class UnitController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::with('fields')->get();

        return view('manager.unit.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.unit.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UnitRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        $data = $request->all();
        $data['created_user_id'] = Auth::user()->id;

        $unit = Unit::create($data);
        flash()->success('Thành công', 'Đã tạo đơn vị mới: ' . $unit->name);

        return Redirect::route('unit.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $unit = Unit::findBySlug($slug);
        if (is_null($unit)) {
            flash()->error('Lỗi', 'Không tìm thấy lĩnh vực');

            return back();
        }

        return view('manager.unit.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $unit = Unit::findBySlug($slug);
        if (is_null($unit)) {
            flash()->error('Lỗi', 'Không tìm thấy lĩnh vực');

            return back();
        }

        return view('manager.unit.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UnitRequest $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, $slug)
    {
        $data = $request->all();
        $data['modified_user_id'] = Auth::user()->id;

        $unit = Unit::findBySlug($slug);
        $unit->slug = null;
        $unit->update($data);

        flash()->success('Thành công', 'Đã cập nhật thông tin đơn vị thành công');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $unit = Unit::findBySlug($slug);
        $fields = $unit->fields;
        if (count($fields) > 0) {
            flash()->overlay('Xóa không thành công', 'Hiện có lĩnh vực thuộc đơn vị nên không được phép xóa', 'info');

            return Redirect::route('unit.index');
        }
        $name = $unit->name;
        $unit->delete();

        flash()->success('Thành công', 'Đã xóa lĩnh vực ' . $name);

        return Redirect::route('unit.index');
    }

    /* FUNCTIONS FOR CONNECT */
    public function connectTeacher(Request $request)
    {
        $data = $request->all();

        if (!isset($data['unit_id'])) {
            return '<div align="center">Thiếu dữ liệu gửi lên</div>';
        }

        $unit = Unit::find($data['unit_id']);

        if (is_null($unit)) {
            return '<div align="center">Không tìm thấy đơn vị</div>';
        }

        if (isset($data['teacher_connect']) && $data['teacher_connect'] != null && $data['teacher_connect'] != '') {
            $data['teacher_connect'] = explode(',', $data['teacher_connect']);
            $data['created_user_id'] = Auth::user()->id;
            $unit->teachers()->attach($data['teacher_connect'], ['created_user_id' => Auth::user()->id]);
        }

        if (isset($data['teacher_disconnect']) && $data['teacher_disconnect'] != null && $data['teacher_disconnect'] != '') {
            $data['teacher_disconnect'] = explode(',', $data['teacher_disconnect']);
            if ($data['teacher_disconnect'] != '') {
                $unit->teachers()->detach($data['teacher_disconnect'], ['created_user_id' => Auth::user()->id]);
            }
        }

        $teachers_connect = $unit->teachers()->get();
        $teachers_disconnect = User::join('role_user as ru', 'users.id', '=', 'ru.user_id')
            ->join('roles as r', 'r.id', '=', 'ru.role_id')
            ->where('users.status', '=', 1)
            ->where('r.code', '=', 'GV')
            ->whereNotIn('users.id', function ($query) {
                $query->select('user_id')->from('teacher_unit');
            })
            ->select('users.*')->get();

        return view('manager.unit.teacher-connect-unit', compact('teachers_connect', 'teachers_disconnect', 'unit'));
    }


}
