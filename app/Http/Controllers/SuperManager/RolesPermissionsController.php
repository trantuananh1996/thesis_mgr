<?php

namespace App\Http\Controllers\SuperManager;

use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Role;
use App\Permission;

class RolesPermissionsController extends Controller
{
    public function __construct(){

    }

    public function index(){
       if(Gate::denies('SA_roles_permissions'))
           return redirect('/404');
        
    	$roles = Role::all();

    	$permissions = Permission::all();

    	return view('superManager.roles-permissions.index',compact('roles','permissions'));
    }

    // CRUD roles
    public function addRole(Request $request)
    {
        $data = $request->all();

        $code_strtoupper['code'] = strtoupper(trim($data['code']));
        $code_strtoupper['name'] = trim($data['name']);

        $role_codes = Role::all()->pluck('code')->all();

        if (in_array($code_strtoupper['code'], $role_codes)) {
            return response()->json([
                'code' => 35,
                'message' => 'Trùng Code'
            ]);
        } else {
            $role = new Role;
            $role = $role->store($code_strtoupper);

            return response()->json([
                'code' => 200,
                'message' => 'Thêm Role thành công',
                'data' => array(
                    'id' => $role->id,
                    'name' => $role->name,
                    'code' => $role->code,
                )
            ]);
        }
    }

    public function saveRole(Request $request)
    {
        $data = $request->all();

        if (!isset($data['role_id'])) {
            return response()->json([
                'code' => 32,
                'message' => 'Thiếu dữ liệu gửi lên',
                'params' => $data
            ]);
        }

        $role = Role::whereId($data['role_id'])->first();

        if (is_null($role)) {
            return response()->json([
                'code' => 404,
                'message' => 'Không tìm thấy role',
                'params' => $data
            ]);
        }

        $role_codes = Role::whereNotIn('id', [$data['role_id']])->pluck('code')->all();

        $code_strtoupper['code'] = strtoupper(trim($data['code']));
        $code_strtoupper['name'] = trim($data['name']);

        if (in_array($code_strtoupper['code'], $role_codes)) {
            return response()->json([
                'code' => 35,
                'message' => 'Trùng Code'
            ]);
        } else {
            $role->update($code_strtoupper);

            return response()->json([
                'code' => 200,
                'message' => 'Cập nhật thông tin thành công',
                'data' => array(
                    'name' => $role->name,
                    'code' => $role->code
                )
            ]);
        }
    }

    public function deleteRole(Request $request)
    {
        $data = $request->all();

        if (!isset($data['role_id'])) {
            return response()->json([
                'code' => 32,
                'message' => 'Thiếu dữ liệu gửi lên',
                'params' => $data
            ]);
        }
        $role = Role::whereId($data['role_id'])->firstOrFail();

        if (is_null($role)) {
            return response()->json([
                'code' => 404,
                'message' => 'Không tìm thấy role',
                'params' => $data
            ]);
        }

        $role->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Xóa thành công',
        ]);
    }


    // CRUD permissions
    public function addPermission(Request $request)
    {
        $data = $request->all();

        $permission_codes = Permission::all()->pluck('code')->all();

        if (in_array(trim($data['code']), $permission_codes)) {
            return response()->json([
                'code' => 35,
                'message' => 'Trùng Code'
            ]);
        } else {
            $permission = new Permission;

            $permission = $permission->store($data);

            return response()->json([
                'code' => 200,
                'message' => 'Thêm quyền thành công',
                'data' => array(
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'code' => $permission->code,
                )
            ]);
        }
    }

    public function savePermission(Request $request)
    {
        $data = $request->all();

        if (!isset($data['permission_id'])) {
            return response()->json([
                'code' => 32,
                'message' => 'Thiếu dữ liệu gửi lên',
                'params' => $data
            ]);
        }
        $permission = Permission::whereId($data['permission_id'])->first();

        if (is_null($permission)) {
            return response()->json([
                'code' => 404,
                'message' => 'Không tìm thấy quyền này',
                'params' => $data
            ]);
        }

        $permission_codes = Permission::whereNotIn('id', [$data['permission_id']])->pluck('code')->all();

        if (in_array(trim($data['code']), $permission_codes)) {
            return response()->json([
                'code' => 35,
                'message' => 'Trùng Code'
            ]);
        } else {
            $permission->update($data);

            return response()->json([
                'code' => 200,
                'message' => 'Cập nhật thông tin thành công',
                'data' => array(
                    'name' => $permission->name,
                    'code' => $permission->code
                )
            ]);
        }
    }

    public function deletePermission(Request $request)
    {
        $data = $request->all();

        if (!isset($data['permission_id'])) {
            return response()->json([
                'code' => 32,
                'message' => 'Thiếu dữ liệu gửi lên',
                'params' => $data
            ]);
        }
        $permission = Permission::whereId($data['permission_id'])->firstOrFail();

        if(is_null($permission)) {
            return response()->json([
                'code' => 404,
                'message' => 'Không tìm thấy Permission',
                'params' => $data
            ]);
        }

        $permission->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Xóa thành công',
        ]);
    }

    // functions for connect 
    public function show_role_connect_permissions(Request $request){
        $data = $request->all();

        if(!isset($data['role_id']))
            return '<div align="center">Thiếu dữ liệu gửi lên</div>';

        $role = Role::whereId($data['role_id'])->first();

        if(is_null($role))
            return '<div align="center">Không tìm thấy chức vụ này</div>';

        if(isset($data['permissions_connect']) && $data['permissions_connect']!= null && $data['permissions_connect'] != ''){
            $data['permissions_connect'] = explode(',', $data['permissions_connect']);
                $role->permissions()->attach($data['permissions_connect']);
        }

        if(isset($data['permissions_disconnect']) && $data['permissions_disconnect']!= null && $data['permissions_disconnect'] != ''){
            $data['permissions_disconnect'] = explode(',', $data['permissions_disconnect']);
            if($data['permissions_disconnect'] != '')
                $role->permissions()->detach($data['permissions_disconnect']);
        }


        $connect_permissions = $role->permissions()->get();

        $disconnect_permissions = Permission::whereNotIn('id',$connect_permissions->pluck('id'))->get();

        return view('superManager.roles-permissions.role-connect-permissions',compact('role','connect_permissions','disconnect_permissions'));
    }

    public function show_permission_connect_roles(Request $request){
        $data = $request->all();

        if(!isset($data['permission_id']))
            return '<div align="center">Thiếu dữ liệu gửi lên</div>';

        $permission = Permission::whereId($data['permission_id'])->first();

        if(is_null($permission))
            return '<div align="center">Không tìm thấy quyền này</div>';

        if(isset($data['roles_connect']) && $data['roles_connect']!= null && $data['roles_connect'] != ''){
            $data['roles_connect'] = explode(',', $data['roles_connect']);
                $permission->roles()->attach($data['roles_connect']);
        }

        if(isset($data['roles_disconnect']) && $data['roles_disconnect']!= null && $data['roles_disconnect'] != ''){
            $data['roles_disconnect'] = explode(',', $data['roles_disconnect']);
            if($data['roles_disconnect'] != '')
                $permission->roles()->detach($data['roles_disconnect']);
        }


        $connect_roles = $permission->roles()->get();

        $disconnect_roles = Role::whereNotIn('id',$connect_roles->pluck('id'))->get();

        return view('superManager.roles-permissions.permission-connect-roles',compact('permission','connect_roles','disconnect_roles'));
    }
}
