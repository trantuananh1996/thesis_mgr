@extends ('layouts.master')

@section('head')
    <title>Quản lý các đợt đăng ký</title>
    <link rel="stylesheet" href="{{URL::asset('table/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
@stop

@section('top-menu-left')
    <h4>
        QUẢN LÝ CÁC ĐỢT ĐĂNG KÝ
    </h4>
@endsection

@section('content')
    <div class="row" style="position: relative">
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-striped" id="terms_table">
                    <thead>
                    <tr align="left">
                        <th>STT</th>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Tùy chọn</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($terms as $index=>$term)
                        <tr id="term-row{{$term->id}}">
                            <td>{{$index+1}}</td>
                            <td>{{$term->code}}</td>
                            <td>
                                    <span id="label-term-name{{$term->id}}">
                                        {{$term->name}}    
                                    </span>
                                <input type="text" class="form-control" id="input-term-name{{$term->id}}"
                                       value="{{$term->name}}" style="display: none">
                            </td>
                            <td>
                                    <span id="label-term-start-date{{$term->id}}">
                                        {{Carbon\Carbon::parse($term->start_date)->format('d-m-Y')}}
                                    </span>
                                @if($term->start_date > Carbon\Carbon::now()->toDay())
                                    <input type="text" class="form-control default-date-picker"
                                           id="input-term-start-date{{$term->id}}"
                                           value="{{Carbon\Carbon::parse($term->start_date)->format('d-m-Y')}}"
                                           style="display: none">
                                @else
                                    <input type="text" class="form-control default-date-picker"
                                           id="input-term-start-date{{$term->id}}"
                                           value="{{Carbon\Carbon::parse($term->start_date)->format('d-m-Y')}}"
                                           style="display: none" disabled="disabled">
                                @endif
                            </td>
                            <td>
                                    <span id="label-term-end-date{{$term->id}}">
                                        {{Carbon\Carbon::parse($term->end_date)->format('d-m-Y')}}
                                    </span>
                                <input type="text" class="form-control default-date-picker"
                                       id="input-term-end-date{{$term->id}}"
                                       value="{{Carbon\Carbon::parse($term->end_date)->format('d-m-Y')}}"
                                       style="display: none">
                            </td>
                            <td>
                                <a class="btn btn-sm btn-info" id="btn-show-term{{$term->id}}"
                                        href="{{route('terms.show',[$term->code])}}">
                                    <i class="fa fa-eye" data-toggle="tooltip" data-placement="top"
                                       title="Xem"></i>
                                </a>
                                @if($term->end_date >= Carbon\Carbon::now()->toDay())
                                    <button class="btn btn-sm btn-primary" id="btn-edit-term{{$term->id}}"
                                            onclick="edit_term({{$term->id}})">
                                        <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top"
                                           title="Sửa"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success" id="btn-save-term{{$term->id}}"
                                            onclick="save_term({{$term->id}})" style="display: none">
                                        <i class="fa fa-save" data-toggle="tooltip" data-placement="top"
                                           title="Lưu lại"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;"
                                            id="btn-delete-term{{$term->id}}"
                                            onclick="confirm_delete_term({{$term->id}})">
                                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top"
                                           title="Xóa"> </i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            @include('manager.terms.create')
        </div>
    </div>
@stop

@section('page-script')
    <script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    @include('manager.terms.js-script-term')
    <script type="text/javascript">
        $(document).ready(function () {
            form_validate_create($('#form-create-term'));
        });
    </script>
@stop