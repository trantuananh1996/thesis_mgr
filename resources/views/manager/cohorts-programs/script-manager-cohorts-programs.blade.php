<script type="text/javascript">


    // hàm gửi ajax và thêm cohort
    function addCohort(){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        name = $('#input-add-name-cohort').val();
        code = $('#input-add-code-cohort').val();
        count_cohorts =  Number($('#new-cohort').attr('index'));
        user_auth =  $('#new-cohort').attr('login');

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

        url = 'add-cohort';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                name: name,
                code: code,
                user_auth: user_auth,
            },
            success: function (data) {
                if(data.code == undefined){
                    $('#tbody-cohorts').append(data);

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormAddCohort();

                    // Alert message success
                    swal('Thêm niên khóa thành công').catch(swal.noop);
                }
                else if(data.code == 35 ) {
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

    // hàm hiện form thêm cohort
    function showFormAddCohort(){

        $('#row-add-cohort').show();// hiện row form add cohort
    }

    function closeFormAddCohort(id){

        $('#input-add-name-cohort').val("");
        $('#input-add-code-cohort').val("");
        $('#row-add-cohort').hide();// Ẩn row form add cohort
    }

    // hàm hiện form sửa
    function showFormEditCohort(id){
        // tìm đến các thẻ có chứa id này để ẩn hiện hợp lý

        // ẩn các label text
        $('#label-name-cohort'+id).hide();
        $('#label-code-cohort'+id).hide();
        $('#btn-edit-cohort'+id).hide();// ẩn nút edit
        $('#btn-delete-cohort'+id).hide();// ẩn nút delete
        $('#btn-add-programs-cohort'+id).hide();// ẩn nút view

        // hiện các input lên
        $('#input-name-cohort'+id).attr('type','text'); // thẻ này ban đầu type =  hidden nên ẩn,
        // sau đó đổi sang text sẽ hiện lên
        $('#input-code-cohort'+id).attr('type','text');
        $('#btn-save-cohort'+id).show();// hiện nút save
        $('#btn-remove-edit-cohort'+id).show();// hiện nút cancel

    }

    function closeFormEditCohort(id){
        // hiện các label text
        $('#label-name-cohort'+id).show();
        $('#label-code-cohort'+id).show();
        $('#btn-edit-cohort'+id).show();// hiện nút edit
        $('#btn-delete-cohort'+id).show();// hiện nút delete
        $('#btn-add-programs-cohort'+id).show();// ẩn nút view

        // ẩn các input lên
        $('#input-name-cohort'+id).attr('type','hidden');
        $('#input-code-cohort'+id).attr('type','hidden');
        $('#btn-save-cohort'+id).hide();// ẩn nút save
        $('#btn-remove-edit-cohort'+id).hide();// ẩn nút cancel

    }

    // hàm lưu lại và gửi ajax
    function saveCohort(id){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        name = $('#input-name-cohort'+id).val();
        code = $('#input-code-cohort'+id).val();

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

        url = 'save-cohort';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                cohort_id: id,
                name: name,
                code: code,
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == 200 ){  // mặc định 200 là thành công
                    // làm lại dữ liệu đã thay đổi cho các label
                    $('#label-name-cohort'+id).text(data.data.name);
                    $('#label-code-cohort'+id).text(data.data.code);

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormEditCohort(id);

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


    // hàm gửi ajax và xóa cohort
    function deleteCohort(id){
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

            url = 'delete-cohort';
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    cohort_id: id,
                },
                success: function (data) {

                    // hay trả về data mảng dạng {code, message, data};
                    if(data.code == 200 ){  // mặc định 200 là thành công
                        $('#row-cohort'+id).remove();

                        document.getElementById('id-loader-css').style.display = "none";
                        $(".row button").prop('disabled', false);

                        // tắt form edit đi, hiện label
                        closeFormEditCohort(id);

                        // Alert message success
                        swal(data.message, '', 'success');

                        // cohort_table.order( [ 1, 'asc' ] ).draw();
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

    // Jquery Program

    // hàm gửi ajax và thêm Program
    function addProgram(){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        name = $('#input-add-name-program').val();
        code = $('#input-add-code-program').val();
        unit_id = $('#select_unit').val();
        count_Programs =  Number($('#new-program').attr('index'));

        if(name == '') {
            swal('', 'Không được để trống tên', 'error').catch(swal.noop);

            return false;
        }

        if(code == '') {
            swal('', 'Không được để trống mã', 'error').catch(swal.noop);

            return false;
        }

        if(unit_id == 0) {
            swal('', 'Vui lòng chọn đơn vị đào tạo', 'error').catch(swal.noop);

            return false;
        }

        document.getElementById('id-loader-css').style.display = "block";
        $(".row button").prop('disabled', true);

        url = 'add-program';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                name: name,
                code: code,
                unit_id: unit_id
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == undefined ){  // mặc định 200 là thành công
                    count_Programs+=1;
                    // làm lại dữ liệu đã thay đổi cho các label
                    $('#tbody-programs').append(data);

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormAddProgram();

                    // Alert message success
                    swal('Thêm chương trình đào tạo thành công').catch(swal.noop);

                    // program_table.order( [ 1, 'asc' ] ).draw();
                }else if(data.code == 35 ) {
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

    // hàm hiện form thêm Program
    function showFormAddProgram(){

        $('#input-add-name-program').val("");
        $('#input-add-code-program').val("");

        $('#row-add-program').show();// hiện row form add Program
    }

    function closeFormAddProgram(id){

        $('#row-add-program').hide();// Ẩn row form add Program
    }

    // hàm hiện form sửa
    function showFormEditProgram(id){
        // tìm đến các thẻ có chứa id này để ẩn hiện hợp lý

        // ẩn các label text
        $('#label-name-program'+id).hide();
        $('#label-code-program'+id).hide();
        $('#label-unit-program'+id).hide();
        $('#btn-edit-program'+id).hide();// ẩn nút edit
        $('#btn-delete-program'+id).hide();// ẩn nút delete
        $('#btn-add-cohorts-programs'+id).hide();// ẩn nút delete

        // hiện các input lên
        $('#input-name-program'+id).attr('type','text'); // thẻ này ban đầu type =  hidden nên ẩn,
        // sau đó đổi sang text sẽ hiện lên
        $('#input-code-program'+id).attr('type','text');
        $('#input-unit-program'+id).show();
        $('#btn-save-program'+id).show();// hiện nút save
        $('#btn-remove-edit-program'+id).show();// hiện nút cancel

    }

    function closeFormEditProgram(id){
        // hiện các label text
        $('#label-name-program'+id).show();
        $('#label-code-program'+id).show();
        $('#label-unit-program'+id).show();
        $('#btn-edit-program'+id).show();// hiện nút edit
        $('#btn-delete-program'+id).show();// hiện nút delete
        $('#btn-add-cohorts-programs'+id).show();// hiện nút delete

        // ẩn các input lên

        $('#input-name-program'+id).attr('type','hidden');
        $('#input-code-program'+id).attr('type','hidden');
        $('#input-unit-program'+id).hide();
        $('#btn-save-program'+id).hide();// ẩn nút save
         $('#btn-remove-edit-program'+id).hide();// ẩn nút cancel

    }

    // hàm lưu lại và gửi ajax
    function saveProgram(id){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên



        name = $('#input-name-program'+id).val();
        code = $('#input-code-program'+id).val();
        unit_id = $('#input-unit-program'+id).val();

        if(name == '') {
            swal('', 'Không được để trống name', 'error').catch(swal.noop);

            return false;
        }

        if(unit_id == 0 || unit_id == undefined) {
            swal('', 'Vui lòng chọn đơn vị đào tạo', 'error').catch(swal.noop);
            return false;
        }

        if(code == '') {
            swal('', 'Không được để trống code', 'error').catch(swal.noop);
            return false;
        }

        document.getElementById('id-loader-css').style.display = "block";
        $(".row button").prop('disabled', true);

        url = 'save-program';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                program_id: id,
                name: name,
                code: code,
                unit_id: unit_id,
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == 200 ){  // mặc định 200 là thành công
                    // làm lại dữ liệu đã thay đổi cho các label
                    $('#label-name-program'+id).text(data.data.name);
                    $('#label-code-program'+id).text(data.data.code);
                    $('#label-unit-program'+id).text(data.data.unit_name);

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormEditProgram(id);

                    // alert success
                    swal('',data.message).catch(swal.noop);
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

    // hàm gửi ajax và xóa Program
    function deleteProgram(id){
        // tìm đến các thẻ có chứa id này để lấy thông tin gửi ajax lên

        document.getElementById('id-loader-css').style.display = "block";
        $(".row button").prop('disabled', true);

        url = 'delete-program';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                program_id: id,
            },
            success: function (data) {

                // hay trả về data mảng dạng {code, message, data};
                if(data.code == 200 ){  // mặc định 200 là thành công
                    $('#row-program'+id).remove();

                    document.getElementById('id-loader-css').style.display = "none";
                    $(".row button").prop('disabled', false);

                    // tắt form edit đi, hiện label
                    closeFormEditProgram(id);

                    // alert success
                    swal(data.message).catch(swal.noop);

                    // program_table.order( [ 1, 'asc' ] ).draw();
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