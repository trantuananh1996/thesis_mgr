<tr id="row-program{{$program->id}}">
    <td>
        
    </td>
    <td>
        <span id="label-name-program{{$program->id}}" index="{{$program->id}}">
            {{ $program->name }}
        </span>
        <input id="input-name-program{{$program->id}}" style="width: 100%;color: #7A7675" type="hidden" value="{{$program->name}}"
               index="{{$program->id}}" class="form-control">
    </td>
    <td>
        <span id="label-code-program{{$program->id}}" index="{{$program->id}}">
            {{ $program->code }}
        </span>
        <input id="input-code-program{{$program->id}}" style="width: 100%;color: #7A7675" type="hidden" value="{{$program->code}}"
               index="{{$program->id}}" class="form-control">
    </td>
    <td>
        <span id="label-unit-program{{$program->id}}" index="{{$program->id}}">
            @if(!is_null($program->unit))
                {{ $program->unit->name }}
            @endif
        </span>
        <select style="display: none" id="input-unit-program{{$program->id}}" value="{{$program->unit_id}}" index="{{$program->id}}" class="form-control">
            @foreach($units as $unit)
                @if($unit->id == $program->unit_id)
                <option value="{{$unit->id}}" selected>
                @else
                <option value="{{$unit->id}}">
                @endif
                    {{$unit->name}}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <!-- nút hiện form sửa -->
        <button class="btn btn-sm btn-primary" id="btn-edit-program{{$program->id}}"
                onclick="showFormEditProgram({{$program->id}})">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i>
        </button>

        <!-- nút lưu lại bằng ajax và đóng form -->
        <button class="btn btn-sm btn-success" style="display: none" id="btn-save-program{{$program->id}}"
                onclick="saveProgram({{$program->id}})">
            <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>
        </button>

        <!-- nút xóa gửi ajax lên sau đó remove cả dòng cohort này đi (thẻ tr) -->
        <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;"
                onclick="deleteProgram({{$program->id}})" id="btn-delete-program{{$program->id}}">
            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"> </i>
        </button>

        <!-- nút cancel remove cả dòng cohort này đi (thẻ tr) -->
        <button class="btn btn-sm btn-default" data-method="delete" style="display: none"
                onclick="closeFormEditProgram({{$program->id}})"
                id="btn-remove-edit-program{{$program->id}}">
            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Cancel"> </i>
        </button>
    </td>
</tr>