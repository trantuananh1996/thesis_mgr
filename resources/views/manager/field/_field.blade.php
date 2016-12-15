<tr>
    <td style="text-align: center;width: 5%">{{$index + 1}}</td>
    <td>{{$field->code}}</td>
    <td>{{$field->name}}</td>
    <td>{{$field->unit->name}}</td>
    <td>{{$field->description}}</td>
    <td style="width: 12%;text-align: center;vertical-align: middle">
        <a href="{{ route('field.show', ['slug' => $field->slug]) }}" class="btn btn-xs btn-info"><i
                    class="fa fa-eye"></i></a>
        <a href="{{ route('field.edit',['slug' => $field->slug]) }}" class="btn btn-xs btn-success"><i
                    class="fa fa-pencil"></i></a>
        <button class="btn btn-xs btn-warning" title="Xem" data-toggle="modal" data-target="#teachers-fields" onclick="showTeacherConnectField({{$field->id}})">
            <i class="fa fa-users"></i>
        </button>
        <a href="{{ route('field.destroy',['slug' => $field->slug]) }}" class="btn btn-xs btn-danger"
           onclick="return confirmDelete(this.href,'Bạn có muốn xóa lĩnh vực này?')"><i class="fa fa-times"></i></a>
    </td>
</tr>
