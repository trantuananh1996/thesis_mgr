<tr id="row-cohort{{$cohort->id}}">
    <td> </td>
    <td>
        <span id="label-name-cohort{{$cohort->id}}" index="{{$cohort->id}}">
            {{ $cohort->name }}
        </span>
        <input id="input-name-cohort{{$cohort->id}}" style="width: 100%;color: #7A7675" type="hidden" value="{{$cohort->name}}" index="{{$cohort->id}}" class="form-control">
    </td>
    <td>
        <span id="label-code-cohort{{$cohort->id}}" index="{{$cohort->id}}">
            {{ $cohort->code }}
        </span>
        <input id="input-code-cohort{{$cohort->id}}" style="width: 100%;color: #7A7675" type="hidden" value="{{$cohort->code}}" index="{{$cohort->id}}" class="form-control">
    </td>
    <td>
        <!-- nút hiện form sửa -->
        <button class="btn btn-sm btn-primary" id="btn-edit-cohort{{$cohort->id}}" onclick="showFormEditCohort({{$cohort->id}})">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i>
        </button>

        <!-- nút lưu lại bằng ajax và đóng form -->
        <button class="btn btn-sm btn-success" style="display: none" id="btn-save-cohort{{$cohort->id}}" onclick="saveCohort({{$cohort->id}})">
            <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>
        </button>

        <!-- nút hiện form thêm programs cho cohort -->
        <button class="btn btn-sm btn-info" title="Xem" data-toggle="modal" data-target="#cohorts-programs" onclick="showCohortsPrograms({{$cohort->id}})">
            <i class="fa fa-eye"></i>
        </button>

        <!-- nút xóa gửi ajax lên sau đó remove cả dòng cohort này đi (thẻ tr) -->
        <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;"
                onclick="deleteCohort({{$cohort->id}})" id="btn-delete-cohort{{$cohort->id}}">
            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"> </i>
        </button>

        <!-- nút cancel remove cả dòng cohort này đi (thẻ tr) -->
        <button class="btn btn-sm btn-default" data-method="delete" style="display: none"
                onclick="closeFormEditCohort({{$cohort->id}})" id="btn-remove-edit-cohort{{$cohort->id}}">
            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Cancel"> </i>
        </button>
    </td>
</tr>