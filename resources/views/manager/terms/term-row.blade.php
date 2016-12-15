<tr id="term-row{{$term->id}}">
    <td></td>
    <td>{{$term->code}}</td>
    <td>
        <span id="label-term-name{{$term->id}}">
            {{$term->name}}    
        </span>
        <input type="text" class="form-control" id="input-term-name{{$term->id}}" value="{{$term->name}}" style="display: none">
    </td>
    <td>
        <span id="label-term-start-date{{$term->id}}">
            {{Carbon\Carbon::parse($term->start_date)->format('d-m-Y')}}
        </span>
        @if($term->start_date > Carbon\Carbon::now()->toDay())
        <input type="text" class="form-control default-date-picker" id="input-term-start-date{{$term->id}}" value="{{Carbon\Carbon::parse($term->start_date)->format('d-m-Y')}}" style="display: none">
        @else
        <input type="text" class="form-control default-date-picker" id="input-term-start-date{{$term->id}}" value="{{Carbon\Carbon::parse($term->start_date)->format('d-m-Y')}}" style="display: none" disabled="disabled">
        @endif
    </td>
    <td>
        <span id="label-term-end-date{{$term->id}}">
            {{Carbon\Carbon::parse($term->end_date)->format('d-m-Y')}}
        </span>
        <input type="text" class="form-control default-date-picker" id="input-term-end-date{{$term->id}}" value="{{Carbon\Carbon::parse($term->end_date)->format('d-m-Y')}}" style="display: none">
    </td>
    <td>
        @if($term->end_date >= Carbon\Carbon::now()->toDay())
        <button class="btn btn-sm btn-primary" id="btn-edit-term{{$term->id}}" onclick="edit_term({{$term->id}})">
            <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Sửa"></i>
        </button>
        <button class="btn btn-sm btn-success" id="btn-save-term{{$term->id}}" onclick="save_term({{$term->id}})" style="display: none">
            <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Lưu lại"></i>
        </button>
        <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;" id="btn-delete-term{{$term->id}}" onclick="confirm_delete_term({{$term->id}})">
            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Xóa"> </i>
        </button>
        @endif
    </td>
</tr>
<script type="text/javascript">
    $('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });
</script>