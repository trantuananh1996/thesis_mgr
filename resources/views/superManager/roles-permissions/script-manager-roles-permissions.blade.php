<script type="text/javascript">


    // hàm gửi ajax và thêm role
    function addRole(){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        name = $('#input-add-name-role').val();
        code = $('#input-add-code-role').val();
        count_roles =  Number($('#new-role').attr('index'));
        user_auth =  $('#new-role').attr('login');

        if(name == '') {
            swal('', 'Không được để trống name', 'error').catch(swal.noop);

            return false;
        }

        if(code == '') {
            swal('', 'Không được để trống code', 'error').catch(swal.noop);

            return false;
        }

        document.getElementById('id-loader-css').style.display = "block";
        $(".row button").prop('disabled', true);

        url = 'roles-permissions/add-role';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                name: name,
                code: code,
                user_auth: user_auth,
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == 200 ){  // mặc định 200 là thành công
                    count_roles+=1;
                    // làm lại dữ liệu đã thay đổi cho các label
                    id_role = data.data.id;
                    name_n = data.data.name;
                    code_n = data.data.code;

                    $('#tbody-roles').append('<tr id="row-role' + id_role + '">'+
                            '<td>'+count_roles+'</td>'+
                            '<td>' +
                            '<span id="label-name-role' + id_role + '" index="' +id_role + '">' + name_n + '</span>' +
                            '<input id="input-name-role' + id_role + '" type="hidden" value="' + name_n + '" ' +
                            'index="' + id_role + '" class="form-control">' +
                            '</td>' +
                            '<td>' +
                            '<span id="label-code-role' + id_role + '" index="' + id_role + '">' + code_n + '</span>' +
                            '<input id="input-code-role' + id_role + '" type="hidden" value="' + code_n + '" ' +
                            'index="' + id_role + '" class="form-control">' +
                            '</td>' +
                            '<td>' +
                            '<button class="btn btn-sm btn-primary" style="margin-right: 5px;" id="btn-edit-role' + id_role + '" ' +
                            'onclick="showFormEditRole(' +id_role + ')">' +
                            '<i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-primary" id="btn-add-permissions-role' + id_role + '">' +
                            '<a href="roles-permissions/roles/' +id_role + '/add-permissions-for-role">' +
                            '<i class="fa fa-eye" style="color: white" data-toggle="tooltip" data-placement="top" title="Add Permissions"></i>' +
                            '</a>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;margin-left: 4px;"' +
                            'onclick="deleteRole(' +id_role + ')" id="btn-delete-role' +id_role + '">' +
                            '<i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"> </i>' +
                            '</button>' +

                            '<button class="btn btn-sm btn-success" style="display: none" id="btn-save-role' + id_role + '" ' +
                            'onclick="saveRole(' + id_role + ')">' +
                            '<i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>' +
                            '</button>' +

                            '<button class="btn btn-sm btn-default" data-method="delete" style="display: none"' +
                            'onclick="closeFormEditRole(' + id_role + ')" id="btn-remove-edit-role' + id_role + '">' +
                            '<i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Cancel"> </i>' +
                            '</button>' +
                            '</td>' +
                            '</tr>');

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormAddRole();

                    // Alert message success
                    swal(data.message).catch(swal.noop);

                    // role_table.order( [ 1, 'asc' ] ).draw();

                }

                if(data.code == 35 ) {
                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    swal('', data.message, 'error').catch(swal.noop);
                }

            },
            error: function(){
                document.getElementById('id-loader-css').style.display = "none";
                $(".row button").prop('disabled', false);

                // Alert message error
                swal('', 'Không thực hiện được hành động này!', 'error').catch(swal.noop);
            }
        });

    }

    // hàm hiện form thêm Role
    function showFormAddRole(){

        $('#row-add-role').show();// hiện row form add role
    }

    function closeFormAddRole(id){

        $('#input-add-name-role').val("");
        $('#input-add-code-role').val("");
        $('#row-add-role').hide();// Ẩn row form add role
    }

    // hàm hiện form sửa
    function showFormEditRole(id){
        // tìm đến các thẻ có chứa id này để ẩn hiện hợp lý

        // ẩn các label text
        $('#label-name-role'+id).hide();
        $('#label-code-role'+id).hide();
        $('#btn-edit-role'+id).hide();// ẩn nút edit
        $('#btn-delete-role'+id).hide();// ẩn nút delete
        $('#btn-add-permissions-role'+id).hide();// ẩn nút view

        // hiện các input lên
        $('#input-name-role'+id).attr('type','text'); // thẻ này ban đầu type =  hidden nên ẩn,
        // sau đó đổi sang text sẽ hiện lên
        $('#input-code-role'+id).attr('type','text');
        $('#btn-save-role'+id).show();// hiện nút save
        $('#btn-remove-edit-role'+id).show();// hiện nút cancel

    }

    function closeFormEditRole(id){
        // hiện các label text
        $('#label-name-role'+id).show();
        $('#label-code-role'+id).show();
        $('#btn-edit-role'+id).show();// hiện nút edit
        $('#btn-delete-role'+id).show();// hiện nút delete
        $('#btn-add-permissions-role'+id).show();// ẩn nút view

        // ẩn các input lên
        $('#input-name-role'+id).attr('type','hidden');
        $('#input-code-role'+id).attr('type','hidden');
        $('#btn-save-role'+id).hide();// ẩn nút save
        $('#btn-remove-edit-role'+id).hide();// ẩn nút cancel

    }

    // hàm lưu lại và gửi ajax
    function saveRole(id){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        name = $('#input-name-role'+id).val();
        code = $('#input-code-role'+id).val();

        if(name == '') {
            swal('', 'Không được để trống name', 'error').catch(swal.noop);

            return false;
        }

        if(code == '') {

            swal('', 'Không được để trống code', 'error').catch(swal.noop);

            return false;
        }

        document.getElementById('id-loader-css').style.display = "block";
        $(".row button").prop('disabled', true);

        url = 'roles-permissions/save-role';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                role_id: id,
                name: name,
                code: code,
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == 200 ){  // mặc định 200 là thành công
                    // làm lại dữ liệu đã thay đổi cho các label
                    $('#label-name-role'+id).text(data.data.name);
                    $('#label-code-role'+id).text(data.data.code);

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormEditRole(id);

                    // Alert message success
                    swal(data.message).catch(swal.noop);

                }

                if (data.code == 35 || data.code == 404 || data.code == 32 ) {
                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    swal('', data.message, 'error').catch(swal.noop);
                }
            },
            error: function(){
                document.getElementById('id-loader-css').style.display = "none";
                $(".row button").prop('disabled', false);

                swal('', 'Không thực hiện được hành động này!', 'error').catch(swal.noop);
            }
        });

    }


    // hàm gửi ajax và xóa role
    function deleteRole(id){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            document.getElementById('id-loader-css').style.display = "block";
            $(".row button").prop('disabled', true);

            url = 'roles-permissions/delete-role';
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    role_id: id,
                },
                success: function (data) {

                    // hay trả về data mảng dạng {code, message, data};
                    if(data.code == 200 ){  // mặc định 200 là thành công
                        $('#row-role'+id).remove();

                        document.getElementById('id-loader-css').style.display = "none";
                        $(".row button").prop('disabled', false);

                        // tắt form edit đi, hiện label
                        closeFormEditRole(id);

                        // Alert message success
                        swal(data.message, '', 'success');

                        // role_table.order( [ 1, 'asc' ] ).draw();
                    }

                    if (data.code == 404 || data.code == 32 ) {
                        document.getElementById('id-loader-css').style.display = "none";
                        $(".row button").prop('disabled', false);

                        swal('', data.message, 'error').catch(swal.noop);
                    }

                },
                error: function(){
                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    swal('', 'Không thực hiện được hành động này!', 'error').catch(swal.noop);
                }
            });


        });



    }

//****************************************************************************//

    // Jquery Permission

    // hàm gửi ajax và thêm Permission
    function addPermission(){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        name = $('#input-add-name-permission').val();
        code = $('#input-add-code-permission').val();
        count_Permissions =  Number($('#new-permission').attr('index'));

        if(name == '') {
            swal('', 'Không được để trống tên', 'error').catch(swal.noop);

            return false;
        }

        if(code == '') {
            swal('', 'Không được để trống mã', 'error').catch(swal.noop);

            return false;
        }

        document.getElementById('id-loader-css').style.display = "block";
        $(".row button").prop('disabled', true);

        url = 'roles-permissions/add-permission';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                name: name,
                code: code,
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == 200 ){  // mặc định 200 là thành công
                    count_Permissions+=1;
                    // làm lại dữ liệu đã thay đổi cho các label
                    permission_id = data.data.id;
                    name_n = data.data.name;
                    code_n = data.data.code;

                    $('#tbody-permissions').append('<tr id="row-permission' + permission_id + '">'+
                            '<td>' + count_Permissions + '</td>'+
                            '<td>' +
                            '<span id="label-name-permission' + permission_id + '" index="' +permission_id + '">' + name_n + '</span>' +
                            '<input id="input-name-permission' + permission_id + '" type="hidden" value="' + name_n + '" ' +
                            'index="' + permission_id + '" class="form-control">' +
                            '</td>' +
                            '<td>' +
                            '<span id="label-code-permission' + permission_id + '" index="' + permission_id + '">' + code_n + '</span>' +
                            '<input id="input-code-permission' + permission_id + '" type="hidden" value="' + code_n + '" ' +
                            'index="' + permission_id + '" class="form-control">' +
                            '</td>' +
                            '<td>' +
                            '<button class="btn btn-sm btn-primary" style="margin-right: 5px;" id="btn-edit-permission' + permission_id + '" ' +
                            'onclick="showFormEditPermission(' +permission_id + ')">' +
                            '<i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit"></i>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-primary" id="btn-add-roles-permissions'+ permission_id +'">' +
                            '<a href="roles-permissions/Permissions/'+ permission_id +'/add-roles-for-permission">' +
                            '<i class="fa fa-eye" style="color: white" data-toggle="tooltip" data-placement="top"' +
                            'title="Add Permissions"></i>' +
                            '</a>' +
                            '</button>' +
                            '<button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;margin-top: 2px;"' +
                            'onclick="deletePermission(' +permission_id + ')" id="btn-delete-permission' +permission_id + '">' +
                            '<i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Delete"> </i>' +
                            '</button>' +

                            '<button class="btn btn-sm btn-success" style="display: none" id="btn-save-permission' + permission_id + '" ' +
                            'onclick="savePermission(' + permission_id + ')">' +
                            '<i class="fa fa-save" data-toggle="tooltip" data-placement="top" title="Save"></i>' +
                            '</button>' +

                            '<button class="btn btn-sm btn-default" data-method="delete" style="display: none"' +
                            'onclick="closeFormEditPermission(' + permission_id + ')" id="btn-remove-edit-permission' + permission_id + '">' +
                            '<i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="Cancel"> </i>' +
                            '</button>' +
                            '</td>' +
                            '</tr>');

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormAddPermission();

                    // Alert message success
                    swal(data.message).catch(swal.noop);

                    // permission_table.order( [ 1, 'asc' ] ).draw();
                }

                if(data.code == 35 ) {
                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    swal('', data.message, 'error').catch(swal.noop);
                }
            },
            error: function(){

                document.getElementById('id-loader-css').style.display = "none";
                $(".row button").prop('disabled', false);

                // Alert message error
                swal('', 'Không thực hiện được hành động này!', 'error').catch(swal.noop);
            }
        });

    }

    // hàm hiện form thêm Permission
    function showFormAddPermission(){

        $('#input-add-name-permission').val("");
        $('#input-add-code-permission').val("");

        $('#row-add-permission').show();// hiện row form add Permission
    }

    function closeFormAddPermission(id){

        $('#row-add-permission').hide();// Ẩn row form add Permission
    }

    // hàm hiện form sửa
    function showFormEditPermission(id){
        // tìm đến các thẻ có chứa id này để ẩn hiện hợp lý

        // ẩn các label text
        $('#label-name-permission'+id).hide();
        $('#label-code-permission'+id).hide();
        $('#btn-edit-permission'+id).hide();// ẩn nút edit
        $('#btn-delete-permission'+id).hide();// ẩn nút delete
        $('#btn-add-roles-permissions'+id).hide();// ẩn nút delete

        // hiện các input lên
        $('#input-name-permission'+id).attr('type','text'); // thẻ này ban đầu type =  hidden nên ẩn,
        // sau đó đổi sang text sẽ hiện lên
        $('#input-code-permission'+id).attr('type','text');
        $('#btn-save-permission'+id).show();// hiện nút save
        $('#btn-remove-edit-permission'+id).show();// hiện nút cancel

    }

    function closeFormEditPermission(id){
        // hiện các label text
        $('#label-name-permission'+id).show();
        $('#label-code-permission'+id).show();
        $('#btn-edit-permission'+id).show();// hiện nút edit
        $('#btn-delete-permission'+id).show();// hiện nút delete
        $('#btn-add-roles-permissions'+id).show();// hiện nút delete

        // ẩn các input lên

        $('#input-name-permission'+id).attr('type','hidden');
        $('#input-code-permission'+id).attr('type','hidden');
        $('#btn-save-permission'+id).hide();// ẩn nút save
         $('#btn-remove-edit-permission'+id).hide();// ẩn nút cancel

    }

    // hàm lưu lại và gửi ajax
    function savePermission(id){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên



        name = $('#input-name-permission'+id).val();
        code = $('#input-code-permission'+id).val();

        if(name == '') {
            swal('', 'Không được để trống name', 'error').catch(swal.noop);

            return false;
        }

        if(code == '') {
            swal('', 'Không được để trống code', 'error').catch(swal.noop);
            return false;
        }

        document.getElementById('id-loader-css').style.display = "block";
        $(".row button").prop('disabled', true);

        url = 'roles-permissions/save-permission';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                permission_id: id,
                name: name,
                code: code,
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == 200 ){  // mặc định 200 là thành công
                    // làm lại dữ liệu đã thay đổi cho các label
                    $('#label-name-permission'+id).text(data.data.name);
                    $('#label-code-permission'+id).text(data.data.code);

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormEditPermission(id);

                    // alert success
                    swal(data.message).catch(swal.noop);
                }

                if (data.code == 35 || data.code == 404 || data.code == 32 ) {
                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    swal('', data.message, 'error').catch(swal.noop);
                }
            },
            error: function(){

                document.getElementById('id-loader-css').style.display = "none";
                $(".row button").prop('disabled', false);

                swal('', 'Không thực hiện được hành động này!', 'error').catch(swal.noop);
            }
        });

    }

    // hàm gửi ajax và xóa Permission
    function deletePermission(id){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        document.getElementById('id-loader-css').style.display = "block";
        $(".row button").prop('disabled', true);

        url = 'roles-permissions/delete-permission';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                permission_id: id,
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == 200 ){  // mặc định 200 là thành công
                    $('#row-permission'+id).remove();

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormEditPermission(id);

                    // alert success
                    swal(data.message).catch(swal.noop);

                    // permission_table.order( [ 1, 'asc' ] ).draw();
                }

                if ( data.code == 404 || data.code == 32 ) {
                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    swal('', data.message, 'error').catch(swal.noop);
                }
            },
            error: function(){

                document.getElementById('id-loader-css').style.display = "none";
                $(".row button").prop('disabled', false);

                // alert success
                swal('', 'Không thực hiện được hành động này!', 'error').catch(swal.noop);
            }
        });
    }

</script>