<script type="text/javascript">
	function create_user(url,table_name,modal_dialog_id){
        if($('#cohorts_programs').length >0)
            cohorts_programs = $('#cohorts_programs').val();
        else
            cohorts_programs = '0,0';
		$.ajax({
            url      : url,
            type     : "POST",
            data     : {
                        username: $('#username').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        password_confirmation: $('#password-confirm').val(),
                        avatar_base_64:$('#avatar_base_64').attr('src') ,
                        dob: $('#dob').val(),
                        gender: $('input[name=gender]:checked').val(),
                        fullName:$('#fullName').val(),
                        phone:$('#phone').val(),
                        address:$('#address').val(),
                        role: $('#role').val(),
                        cohorts_programs: cohorts_programs
                       },
            success  : function(data){
                    if(data.code == undefined){
                        $('#'+table_name+' tbody').append(data);
                        if($('#alert-no-user').length > 0)
                            $('#alert-no-user').hide();
                        alert('Thêm người dùng thành công','','success');
                    }else{
                        alert(data.message,'','warning');
                    }
                    $("#"+modal_dialog_id).modal("hide")
                },
            error:function(){ 
                alert("Không lấy được thông tin này!");    
            }
        });
        return false;
	}

    function showFormEdit(user_id,url,modal_dialog_id){
            $.ajax({
                url      : url,
                type     : "POST",
                data     : {
                            user_id: user_id
                            },
                success  : function(data){
                        $('#'+modal_dialog_id).html(data);
                    },
                error:function(){ 
                    alert("Không lấy được thông tin này!");    
                }
            });
            return false;
    }

    function update_user(user_id,url,row_id,modal_dialog_id){
        $.ajax({
            url      : url,
            type     : "POST",
            data     : {
                        user_id: user_id,
                        password: $('#password-edit').val(),
                        password_confirm: $('#password-confirm-edit').val(),
                        avatar_base_64:$('#avatar_edit_base64').attr('src') ,
                        dob: $('#dob-edit').val(),
                        gender: $('input[name=gender_edit]:checked').val(),
                        fullName:$('#fullName-edit').val(),
                        phone:$('#phone-edit').val(),
                        address:$('#address-edit').val()
                       },
            success  : function(data){
                    if(data.code == undefined){
                        $('#'+row_id).html(data);
                        alert('Cập nhật thông tin người dùng thành công','','success');
                    }
                    else{
                        alert(data.message,'','warning');
                    }
                    $("#"+modal_dialog_id).modal("hide")
                },
            error:function(){ 
                alert("Không lấy được thông tin này!");    
            }
        });

        return false;
    }

    function confirm_delete_user(user_id,url,row_id){
        var run_function = function(){
                $.ajax({
                    url      : url,
                    type     : "POST",
                    data     : {
                                user_id: user_id
                               },
                    success  : function(data){
                            if(data.code == 200){
                                $('#'+row_id).remove();
                                alert(data.message,'','success');
                            }else{
                                alert(data.message,'','error');
                            }
                        },
                    error:function(){ 
                        alert("Không lấy được thông tin này!");    
                    }
                });
            };
        confirm('Bạn muốn xóa người dùng này ?','warning',run_function);
    }

    function form_validate_create(form){
        form.bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username:{
                    message: 'Chưa nhập tên tài khoản',
                    validators: {
                        notEmpty: {
                            message: 'Cần phải nhập tên tài khoản'
                        },
                        remote: {
                            message: 'Tên tài khoản đã được sử dụng',
                            url: '/checkAccount',
                            data: {
                                username: 'username'
                            },
                            type: 'POST',
                            delay: 2000     // Send Ajax request every 2 seconds
                        }
                    }
                },
            email:{
                    message: 'Email chưa đúng định dạng',
                    validators: {
                        remote: {
                            message: 'Địa chỉ email đã được sử dụng',
                            url: '/checkAccount',
                            data: {
                                email: 'email'
                            },
                            type: 'POST',
                            delay: 2000     // Send Ajax request every 2 seconds
                        }
                    }
                },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Mật khẩu không được trống'
                    },
                    identical: {
                        field: 'password_confirmation',
                        message: 'Mật khẩu và nhập lại mật khẩu phải giống nhau'
                    }
                }
            },
            'password_confirmation': {
                validators: {
                    notEmpty: {
                        message: 'Hãy nhập lại mật khẩu'
                    },
                    identical: {
                        field: 'password',
                        message: 'Mật khẩu và nhập lại mật khẩu phải giống nhau'
                    }
                }
            },
            fullName: {
                    message: 'Chưa nhập tên',
                    validators: {
                        notEmpty: {
                            message: 'Cần phải nhập tên'
                        }
                    }
                },
            dob: {
                    message: 'Chưa nhập ngày sinh',
                    validators: {
                        notEmpty: {
                            message: 'Cần phải nhập ngày sinh'
                        }
                    }
                },
        }
        }).on('err.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                data.fv.disableSubmitButtons(false);
            }
        }).on('success.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                
            }
        });

        form.bootstrapValidator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                // handle the invalid form...
            } else {
                
            }
            return false;
        });
    }

    function form_validate_edit(form){
        form.bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            password: {
                validators: {
                    identical: {
                        field: 'password_confirmation',
                        message: 'Mật khẩu và nhập lại mật khẩu phải giống nhau'
                    }
                }
            },
            'password_confirmation': {
                validators: {
                    identical: {
                        field: 'password',
                        message: 'Mật khẩu và nhập lại mật khẩu phải giống nhau'
                    }
                }
            },
            fullName: {
                    message: 'Chưa nhập tên',
                    validators: {
                        notEmpty: {
                            message: 'Cần phải nhập tên'
                        }
                    }
                },
            dob: {
                    message: 'Chưa nhập ngày sinh',
                    validators: {
                        notEmpty: {
                            message: 'Cần phải nhập ngày sinh'
                        }
                    }
                },
        }
        }).on('err.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                data.fv.disableSubmitButtons(false);
            }
        }).on('success.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                
            }
        });

        form.bootstrapValidator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                // handle the invalid form...
            } else {
                
            }
            return false;
        });
    }
    
</script>