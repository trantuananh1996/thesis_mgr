<tr>
    <td style="text-align: center;width: 5%">{{$index + 1}}</td>
    <td>{{$unit->code}}</td>
    <td>{{$unit->name}}</td>
    <td>{{$unit->description}}</td>
    <td style="width: 12%;text-align: center;vertical-align: middle">
        <a href="{{ route('unit.show', ['slug' => $unit->slug]) }}" class="btn btn-xs btn-info"><i
                    class="fa fa-eye"></i></a>
        <a href="{{ route('unit.edit',['slug' => $unit->slug]) }}" class="btn btn-xs btn-success"><i
                    class="fa fa-pencil"></i></a>
        <button class="btn btn-xs btn-warning" title="Xem" data-toggle="modal" data-target="#teachers-units" onclick="showTeacherConnectUnit({{$unit->id}})">
            <i class="fa fa-users"></i>
        </button>

        <a href="{{ route('unit.destroy',['slug' => $unit->slug]) }}" class="btn btn-xs btn-danger"
           onclick="return confirmDelete(this.href,'Bạn có muốn xóa đơn vị này?')"><i class="fa fa-times"></i></a>
    </td>
</tr>
