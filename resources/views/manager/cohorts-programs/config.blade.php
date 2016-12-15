@extends ('layouts.master')

@section('head')
    <title>Niên khóa - Chương trình đào tạo</title>
    <!-- <link href="{{asset('css/dataTable.css')}}" rel="stylesheet"/> -->
    <link rel="stylesheet" href="{{URL::asset('table/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
    <style>
        .dataTables_filter label input {
            float: right;
            margin-left: 10px !important;
            width: 55%;
        }

        .panel-body .actions-header {
            float: left;
            width: 100%;
        }

        .panel-body .span6 {
            width: 50%;
            float: left;
        }

        .dataTables_filter label {
            text-align: right;
            line-height: 33px;
        }

        #hidden-table-info_length label {
            width: 100%;
            line-height: 33px;
        }

        .dataTables_length select {
            float: left;
            margin-right: 10px;
        }

        .dataTables_info {
            line-height: 33px;
        }

        table tr td input {
            color: #7A7675 !important;
        }

        .dataTables_length, .dataTables_filter {
            padding: 15px 0px;
        }

        #new-cohort i,
        #new-program i {
            margin-left: 6px;
        }

        .panel-heading .btn-group {
            margin-left: 10px;
        }

        @media (min-width: 768px) {
            .form-inline .form-control {
                width: 100% !important;
            }
        }

        .fa-eye {
            color: white !important;
        }

        #row-add-cohort {
            float: left;
            width: 100%;
            padding-left: 50px;
        }

        .add-name-div {
            float: left;
            width: 40%;
        }

        .add-code-div {
            float: left;
            width: 30%;
            margin-left: 10px;
        }

        .add-button-div {
            float: left;
            width: 10%;
            margin-left: 10px;
        }
    </style>
@stop

@section('top-menu-left')
    <h4>
        <a href="{{asset('/cohorts-programs')}}" class="btn btn-info btn-round" title="Quay lại">
            <i class="fa fa-mail-reply"></i>
        </a>
        NIÊN KHÓA - CHƯƠNG TRÌNH ĐÀO TẠO - THIẾT LẬP KẾT NỐI
    </h4>
@endsection

@section('content')
    

    <div class="row" style="position: relative">

        <input type="text" style="display: none" id="user_auth" value="{{Auth::user()->id}}">

        <div class="loader" id="id-loader-css"
             style="display: none;margin: 0 auto;z-index: 1;float: left;margin-left: 40%;
             margin-top: 10%;position: fixed;border: none !important;">
            <div class="loader-inner ball-spin-fade-loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <section class="panel">

                <header class="panel-heading">
                    Niên khóa
                    <span class="tools pull-right">   
                        <div class="btn-group">
                            <button id="new-cohort" class="btn btn-primary btn-sm" login="{{ Auth::user()->id }}"  index="{{ count($cohorts) }}"
                                    onclick="showFormAddCohort()">
                                Thêm niên khóa <i class="fa fa-plus"></i>
                            </button>
                        </div>     
                    </span>
                </header>

                <!-- MODAL MANAGER cohortS - programS -->
                <div class="modal fade" id="cohorts-programs" tabindex="-1" cohort="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
                    <div class="modal-content" id="cohorts-programs-panel" style="width:75%; margin:auto; margin-top:20px;">

                    </div>
                </div>
                <script type="text/javascript">
                    function showCohortsPrograms(cohort_id){
                        $.ajax({
                            url      : 'show-cohort-connect-programs',
                            type     : "POST",
                            data     : {
                                        cohort_id: cohort_id
                                        },
                            success  : function(data){
                                    $('#cohorts-programs-panel').html(data);
                                },
                            error:function(){ 
                                alert("Không lấy được thông tin này!");    
                            }
                        });
                        return false;
                    }
                </script>
                <!-- END MODAL -->

                <div class="panel-body">
                    <div id="row-add-cohort" style="display: none;float: left; width: 100%;">
                        <div class="add-name-div" style="float: left; width: 40%;">
                            <input id="input-add-name-cohort" style="width: 100%;color: #7A7675" type="text" placeholder="Tên" class="form-control">
                        </div>
                        <div class="add-code-div" style=" float: left; width: 30%;">
                            <input id="input-add-code-cohort" style="width: 100%;color: #7A7675" type="text" placeholder="Mã" class="form-control">
                        </div>
                        <div class="add-button-div" style="float: left; width: 15%; margin-left: 10px;">
                            <!-- nút lưu lại bằng ajax và đóng form -->
                            <button class="btn btn-sm btn-success" id="btn-save-add-cohort" onclick="addCohort()">
                                <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>
                            </button>

                            <!-- nút cancel remove cả dòng cohort này đi (thẻ tr) -->
                            <button class="btn btn-sm btn-default" data-method="Cancel"
                                    onclick="closeFormAddCohort()" id="btn-remove-add-cohort">
                                <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Cancel"> </i>
                            </button>
                        </div>
                        <div style="border-bottom: 1px solid #e2e2e4; margin-top: 47px; margin-bottom: 5px;"></div>
                    </div>
                    <table class="table table-hover" id="cohorts-table">
                        <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th>Tên</th>
                            <th>Mã</th>
                            <th width="30%">Tùy chọn</th>
                        </tr>
                        </thead>
                        <tbody id="tbody-cohorts">
                        @foreach($cohorts as $index=>$cohort)
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
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </section>
        </div>

        <div class="col-lg-6 col-md-6">
            <section class="panel">
                <header class="panel-heading">
                    Chương trình đào tạo
                    <span class="tools pull-right">
                        <div class="btn-group">
                            <button id="new-program" class="btn btn-primary btn-sm" index="{{ count($programs)}}"
                                    onclick="showFormAddProgram()">
                                Thêm chương trình đào tạo <i class="fa fa-plus"></i>
                            </button>
                        </div>            
                    </span>
                </header>

                <!-- MODAL MANAGER cohortS - programS -->
                <div class="modal fade" id="programs-cohorts" tabindex="-1" cohort="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
                    <div class="modal-content" id="programs-cohorts-panel" style="width:75%; margin:auto; margin-top:20px;">

                    </div>
                </div>
                <script type="text/javascript">
                    function showprogramcohorts(program_id){
                        $.ajax({
                            url      : 'show-program-connect-cohorts',
                            type     : "POST",
                            data     : {
                                        program_id: program_id
                                        },
                            success  : function(data){
                                    $('#programs-cohorts-panel').html(data);
                                },
                            error:function(){ 
                                alert("Không lấy được thông tin này!");    
                            }
                        });
                        return false;
                    }
                </script>
                <!-- END MODAL -->

                <div class="panel-body">
                    <div id="row-add-program" style="display: none;float: left; width: 100%;">
                        <div class="col-md-4">
                            <input id="input-add-name-program" style="width: 100%;color: #7A7675" type="text" placeholder="Tên" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input id="input-add-code-program" style="width: 100%;color: #7A7675" type="text" placeholder="Mã" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <select class="form-control" id="select_unit" value="0">
                                <option value="0">
                                    Chọn đơn vị đào tạo ...
                                </option>
                                @foreach($units as $index=>$unit)
                                    <option value="{{$unit->id}}">
                                        {{$unit->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <!-- nút lưu lại bằng ajax và đóng form -->
                            <button class="btn btn-sm btn-success" id="btn-save-add-program" onclick="addProgram()">
                                <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>
                            </button>

                            <!-- nút cancel remove cả dòng cohort này đi (thẻ tr) -->
                            <button class="btn btn-sm btn-default" data-method="Cancel"
                                    onclick="closeFormAddProgram()" id="btn-remove-add-program">
                                <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Cancel"> </i>
                            </button>
                        </div>
                        <div style="border-bottom: 1px solid #e2e2e4; margin-top: 47px; margin-bottom: 5px;"></div>
                    </div>
                    <table class="table table-hover" id="programs-table">
                        <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th>Tên</th>
                            <th>Mã</th>
                            <th>Trực thuộc đơn vị</th>
                            <th width="20%">Tùy chọn</th>
                        </tr>
                        </thead>
                        <tbody id="tbody-programs">
                        @foreach($programs as $indexM=>$program)
                            <tr id="row-program{{$program->id}}">
                                <td>
                                    {{ $indexM+1}}
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
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </section>

        </div>
    </div>

@stop

@section('page-script')

    <script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            cohort_table = $('#cohorts-table').DataTable({
                responsive: true,
                language: {
                    "sProcessing": "Đang xử lý...",
                    "sLengthMenu": "Xem _MENU_ bản ghi",
                    "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                    "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ bản ghi",
                    "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 bản ghi",
                    "sInfoFiltered": "(được lọc từ _MAX_ bản ghi)",
                    "sInfoPostFix": "",
                    "sSearch": "Tìm kiếm:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Đầu",
                        "sPrevious": "Trước",
                        "sNext": "Tiếp",
                        "sLast": "Cuối"
                    }
                },
                aLengthMenu: [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"]
                ],
                iDisplayLength: 10,
                "order": [[ 1, 'asc' ]]
            });

            cohort_table.on( 'order.dt search.dt', function () {
                cohort_table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();

            program_table = $('#programs-table').DataTable({
                responsive: true,
                language: {
                    "sProcessing": "Đang xử lý...",
                    "sLengthMenu": "Xem _MENU_ bản ghi",
                    "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                    "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ bản ghi",
                    "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 bản ghi",
                    "sInfoFiltered": "(được lọc từ _MAX_ bản ghi)",
                    "sInfoPostFix": "",
                    "sSearch": "Tìm kiếm:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Đầu",
                        "sPrevious": "Trước",
                        "sNext": "Tiếp",
                        "sLast": "Cuối"
                    }
                },
                aLengthMenu: [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"]
                ],
                iDisplayLength: 10,
                "order": [[ 1, 'asc' ]]
            });

            program_table.on( 'order.dt search.dt', function () {
                program_table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();
        });

    </script>
    @include('manager.cohorts-programs.script-manager-cohorts-programs')
@stop