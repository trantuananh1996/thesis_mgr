@if($action=='create')
<tr id="student-row{{$student->id}}">
@endif
    <tr id="student-row{{$student->id}}">
    <td></td>
    <td><img width="50px" src="{{asset($student->avatar)}}"></td>
    <td>{{$student->username}}</td>
    <td>{{$student->getFullName()}}</td>
    <td>{{$student->email}}</td>
    <td>{{$student->phone}}</td>
    <td>{{$student->cohort_name}}</td>
    <td>{{$student->program_name}}</td>
    @can('users_act')
    <td>
        <button class="btn btn-sm btn-primary" id="btn-edit-student{{$student->id}}" onclick="showFormEdit({{$student->id}},'students/edit','formEditStudent')" data-toggle="modal" data-target="#editStudent">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Sửa"></i>
        </button>

        <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;" id="btn-delete-student{{$student->id}}" onclick="confirm_delete_user({{$student->id}},'students/delete','student-row{{$student->id}}')">
            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Xóa"> </i>
        </button>
    </td>
    @endcan
</tr>
@if($action=='create')
</tr>
@endif