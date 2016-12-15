@extends ('layouts.master')

@section('head')
    <title>Phân quyền - chức năng</title>
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

        #new-role i,
        #new-permission i {
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

        #row-add-role {
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
    <h4>PHÂN QUYỀN - CHỨC NĂNG CỦA NGƯỜI DÙNG</h4>
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
                    Chức vụ người dùng
                    <span class="tools pull-right">   
                        <div class="btn-group">
                            <button id="new-role" class="btn btn-primary btn-sm" login="{{ Auth::user()->id }}"  index="{{ count($roles) }}"
                                    onclick="showFormAddRole()">
                                Thêm chức vụ <i class="fa fa-plus"></i>
                            </button>
                        </div>     
                    </span>
                </header>

                <!-- MODAL MANAGER ROLES - PERMISSIONS -->
                <div class="modal fade" id="roles-permissions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
                    <div class="modal-content" id="roles-permissions-panel" style="width:75%; margin:auto; margin-top:20px;">

                    </div>
                </div>
                <script type="text/javascript">
                    function showRolesPermissions(role_id){
                        $.ajax({
                            url      : 'roles-permissions/show-role-connect-permissions',
                            type     : "POST",
                            data     : {
                                        role_id: role_id
                                        },
                            success  : function(data){
                                    $('#roles-permissions-panel').html(data);
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
                    <div id="row-add-role" style="display: none;float: left; width: 100%;">
                        <div class="add-name-div" style="float: left; width: 40%;">
                            <input id="input-add-name-role" style="width: 100%;color: #7A7675" type="text" placeholder="Tên" class="form-control">
                        </div>
                        <div class="add-code-div" style=" float: left; width: 30%;">
                            <input id="input-add-code-role" style="width: 100%;color: #7A7675" type="text" placeholder="Mã" class="form-control">
                        </div>
                        <div class="add-button-div" style="float: left; width: 15%; margin-left: 10px;">
                            <!-- nút lưu lại bằng ajax và đóng form -->
                            <button class="btn btn-sm btn-success" id="btn-save-add-role" onclick="addRole()">
                                <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>
                            </button>

                            <!-- nút cancel remove cả dòng role này đi (thẻ tr) -->
                            <button class="btn btn-sm btn-default" data-method="Cancel"
                                    onclick="closeFormAddRole()" id="btn-remove-add-role">
                                <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Cancel"> </i>
                            </button>
                        </div>
                        <div style="border-bottom: 1px solid #e2e2e4; margin-top: 47px; margin-bottom: 5px;"></div>
                    </div>
                    <table class="table table-hover" id="roles-table">
                        <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th>Tên</th>
                            <th>Mã</th>
                            <th width="30%">Tùy chọn</th>
                        </tr>
                        </thead>
                        <tbody id="tbody-roles">
                        @foreach($roles as $index=>$role)
                            <tr id="row-role{{$role->id}}">
                                <td> </td>
                                <td>
                                    <span id="label-name-role{{$role->id}}" index="{{$role->id}}">
                                        {{ $role->name }}
                                    </span>
                                    <input id="input-name-role{{$role->id}}" style="width: 100%;color: #7A7675" type="hidden" value="{{$role->name}}" index="{{$role->id}}" class="form-control">
                                </td>
                                <td>
                                    <span id="label-code-role{{$role->id}}" index="{{$role->id}}">
                                        {{ $role->code }}
                                    </span>
                                    <input id="input-code-role{{$role->id}}" style="width: 100%;color: #7A7675" type="hidden" value="{{$role->code}}" index="{{$role->id}}" class="form-control">
                                </td>
                                <td>
                                    <!-- nút hiện form sửa -->
                                    <button class="btn btn-sm btn-primary" id="btn-edit-role{{$role->id}}" onclick="showFormEditRole({{$role->id}})">
                                        <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                    </button>

                                    <!-- nút lưu lại bằng ajax và đóng form -->
                                    <button class="btn btn-sm btn-success" style="display: none" id="btn-save-role{{$role->id}}" onclick="saveRole({{$role->id}})">
                                        <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>
                                    </button>

                                    <!-- nút hiện form thêm permissions cho role -->
                                    <button class="btn btn-sm btn-info" title="Xem" data-toggle="modal" data-target="#roles-permissions" onclick="showRolesPermissions({{$role->id}})">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <!-- nút xóa gửi ajax lên sau đó remove cả dòng role này đi (thẻ tr) -->
                                    <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;"
                                            onclick="deleteRole({{$role->id}})" id="btn-delete-role{{$role->id}}">
                                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"> </i>
                                    </button>

                                    <!-- nút cancel remove cả dòng role này đi (thẻ tr) -->
                                    <button class="btn btn-sm btn-default" data-method="delete" style="display: none"
                                            onclick="closeFormEditRole({{$role->id}})" id="btn-remove-edit-role{{$role->id}}">
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
                    Quyền thao tác
                    <span class="tools pull-right">
                        <div class="btn-group">
                            <button id="new-permission" class="btn btn-primary btn-sm" index="{{ count($permissions)}}"
                                    onclick="showFormAddPermission()">
                                Thêm quyền <i class="fa fa-plus"></i>
                            </button>
                        </div>            
                    </span>
                </header>

                <!-- MODAL MANAGER ROLES - PERMISSIONS -->
                <div class="modal fade" id="permissions-roles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
                    <div class="modal-content" id="permissions-roles-panel" style="width:75%; margin:auto; margin-top:20px;">

                    </div>
                </div>
                <script type="text/javascript">
                    function showPermissionRoles(permission_id){
                        $.ajax({
                            url      : 'roles-permissions/show-permission-connect-roles',
                            type     : "POST",
                            data     : {
                                        permission_id: permission_id
                                        },
                            success  : function(data){
                                    $('#permissions-roles-panel').html(data);
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
                    <div id="row-add-permission" style="display: none;float: left; width: 100%;">
                        <div class="add-name-div" style="float: left; width: 40%;margin-left: 50px;">
                            <input id="input-add-name-permission" style="width: 100%;color: #7A7675" type="text" placeholder="Tên" class="form-control">
                        </div>
                        <div class="add-code-div" style=" float: left; width: 30%; margin-left: 10px;">
                            <input id="input-add-code-permission" style="width: 100%;color: #7A7675" type="text" placeholder="Mã" class="form-control">
                        </div>
                        <div class="add-button-div" style="float: left; width: 15%; margin-left: 10px;">
                            <!-- nút lưu lại bằng ajax và đóng form -->
                            <button class="btn btn-sm btn-success" id="btn-save-add-permission" onclick="addPermission()">
                                <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>
                            </button>

                            <!-- nút cancel remove cả dòng role này đi (thẻ tr) -->
                            <button class="btn btn-sm btn-default" data-method="Cancel"
                                    onclick="closeFormAddPermission()" id="btn-remove-add-permission">
                                <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Cancel"> </i>
                            </button>
                        </div>
                        <div style="border-bottom: 1px solid #e2e2e4; margin-top: 47px; margin-bottom: 5px;"></div>
                    </div>
                    <table class="table table-hover" id="permissions-table">
                        <thead>
                        <tr>
                            <th width="5%">STT</th>
                            <th>Tên</th>
                            <th>Mã</th>
                            <th width="30%">Tùy chọn</th>
                        </tr>
                        </thead>
                        <tbody id="tbody-permissions">
                        @foreach($permissions as $indexM=>$permission)
                            <tr id="row-permission{{$permission->id}}">
                                <td>
                                    {{ $indexM+1}}
                                </td>
                                <td>
                                    <span id="label-name-permission{{$permission->id}}" index="{{$permission->id}}">
                                        {{ $permission->name }}
                                    </span>
                                    <input id="input-name-permission{{$permission->id}}" style="width: 100%;color: #7A7675" type="hidden" value="{{$permission->name}}"
                                           index="{{$permission->id}}" class="form-control">
                                </td>
                                <td>
                                    <span id="label-code-permission{{$permission->id}}" index="{{$permission->id}}">
                                        {{ $permission->code }}
                                    </span>
                                    <input id="input-code-permission{{$permission->id}}" style="width: 100%;color: #7A7675" type="hidden" value="{{$permission->code}}"
                                           index="{{$permission->id}}" class="form-control">
                                </td>
                                <td>
                                    <!-- nút hiện form sửa -->
                                    <button class="btn btn-sm btn-primary" id="btn-edit-permission{{$permission->id}}"
                                            onclick="showFormEditPermission({{$permission->id}})">
                                        <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i>
                                    </button>

                                    <!-- nút lưu lại bằng ajax và đóng form -->
                                    <button class="btn btn-sm btn-success" style="display: none" id="btn-save-permission{{$permission->id}}"
                                            onclick="savePermission({{$permission->id}})">
                                        <i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>
                                    </button>

                                     <!-- nút hiện form thêm roles cho permission -->
                                    <button class="btn btn-sm btn-info" title="Xem" data-toggle="modal" data-target="#permissions-roles" onclick="showPermissionRoles({{$permission->id}})">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <!-- nút xóa gửi ajax lên sau đó remove cả dòng role này đi (thẻ tr) -->
                                    <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;"
                                            onclick="deletePermission({{$permission->id}})" id="btn-delete-permission{{$permission->id}}">
                                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"> </i>
                                    </button>

                                    <!-- nút cancel remove cả dòng role này đi (thẻ tr) -->
                                    <button class="btn btn-sm btn-default" data-method="delete" style="display: none"
                                            onclick="closeFormEditPermission({{$permission->id}})"
                                            id="btn-remove-edit-permission{{$permission->id}}">
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

            role_table = $('#roles-table').DataTable({
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

            role_table.on( 'order.dt search.dt', function () {
                role_table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();

            permission_table = $('#permissions-table').DataTable({
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

            permission_table.on( 'order.dt search.dt', function () {
                permission_table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();
        });

    </script>
    @include('superManager.roles-permissions.script-manager-roles-permissions')
@stop