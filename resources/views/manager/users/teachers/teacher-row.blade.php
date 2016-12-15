@if($action=='create')
<tr id="teacher-row{{$teacher->id}}">
@endif
	<td></td>
    <td><img width="50px" src="{{asset($teacher->avatar)}}"></td>
    <td>{{$teacher->username}}</td>
    <td>{{$teacher->getFullName()}}</td>
    <td>{{$teacher->email}}</td>
    <td>{{$teacher->phone}}</td>
    <td>Tên đơn vị</td>
    @can('users_act')
    <td>
        <button class="btn btn-sm btn-primary" id="btn-edit-teacher{{$teacher->id}}" onclick="showFormEdit({{$teacher->id}},'teachers/edit','formEditTeacher')" data-toggle="modal" data-target="#editTeacher">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Sửa"></i>
        </button>

        <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;" id="btn-delete-teacher{{$teacher->id}}" onclick="confirm_delete_user({{$teacher->id}},'teachers/delete','teacher-row{{$teacher->id}}')">
            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Xóa"> </i>
        </button>
    </td>
    @endcan
@if($action=='create')
</tr>    
@endif