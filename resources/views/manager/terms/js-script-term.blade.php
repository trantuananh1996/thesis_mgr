<script type="text/javascript">
	function form_validate_create(form){
        form.bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                    message: 'Chưa nhập tên đợt thu',
                    validators: {
                        notEmpty: {
                            message: 'Cần phải nhập tên đợt thu'
                        }
                    }
                },
            start_date: {
                    message: 'Chưa nhập ngày bắt đầu',
                    validators: {
                        notEmpty: {
                            message: 'Cần phải nhập ngày bắt đầu'
                        }
                    }
                },
            end_date: {
                    message: 'Chưa nhập ngày kết thúc',
                    validators: {
                        notEmpty: {
                            message: 'Cần phải nhập ngày kết thúc'
                        }
                    }
                },
        }
        }).on('err.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                // data.fv.disableSubmitButtons(false);
            }
        }).on('success.field.fv', function(e, data) {
            if (data.fv.getSubmitButton()) {
                // create_term('terms_table');
            }
        });

        form.bootstrapValidator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                
            } else {
                
            }
            return false;
        });
    }

    function create_term(table_name){
    	$.ajax({
            url      : 'terms/create',
            type     : "POST",
            data     : {
                        name: $('#create_name').val(),
                        start_date: $('#create_start_date').val(),
                        end_date: $('#create_end_date').val(),
                       },
            success  : function(data){
                    if(data.code == undefined){
                        $('#'+table_name+' tbody').append(data);
                        alert('Thêm đợt đăng ký thành công','','success');
                    }else{
                        alert(data.message,'','warning');
                    }
                },
            error:function(){ 
                alert("Không thực hiện được hành động này!",'','error');    
            }
        });
        return false;
    }

    function open_form_edit(term_id){
    	$('#label-term-name'+term_id).hide();
    	$('#label-term-start-date'+term_id).hide();
    	$('#label-term-end-date'+term_id).hide();
    	$('#btn-edit-term'+term_id).hide();

		$('#input-term-name'+term_id).show();
    	$('#input-term-start-date'+term_id).show();
    	$('#input-term-end-date'+term_id).show();   
    	$('#btn-save-term'+term_id).show();
    }

    function close_form_edit(term_id){
    	$('#label-term-name'+term_id).show();
    	$('#label-term-start-date'+term_id).show();
    	$('#label-term-end-date'+term_id).show();
    	$('#btn-edit-term'+term_id).show();

		$('#input-term-name'+term_id).hide();
    	$('#input-term-start-date'+term_id).hide();
    	$('#input-term-end-date'+term_id).hide();   
    	$('#btn-save-term'+term_id).hide();
    }

    function edit_term(term_id){
    	open_form_edit(term_id);
    }

    function save_term(term_id){
    	$.ajax({
            url      : 'terms/update',
            type     : "POST",
            data     : {
            			term_id: term_id,
                        name: $('#input-term-name'+term_id).val(),
                        start_date: $('#input-term-start-date'+term_id).val(),
                        end_date: $('#input-term-end-date'+term_id).val(),
                       },
            success  : function(data){
                    if(data.code == 200){
                        $('#label-term-name'+term_id).html(data.data.name);
    					$('#label-term-start-date'+term_id).html(data.data.start_date);
    					$('#label-term-end-date'+term_id).html(data.data.end_date);
                        close_form_edit(term_id);
                        alert('Cập nhật thông tin thành công','','success');
                    }else{
                        alert(data.message,'','warning');
                    }
                },
            error:function(){ 
                alert("Không thực hiện được hành động này!",'','error');    
            }
        });
        return false;	
    }

    function confirm_delete_term(term_id){
    	var run_function = function(){
                $.ajax({
                    url      : 'terms/delete',
                    type     : "POST",
                    data     : {
                                term_id: term_id
                               },
                    success  : function(data){
                            if(data.code == 200){
                                $('#term-row'+term_id).remove();
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
        confirm('Bạn muốn xóa đợt đăng ký này ?','warning',run_function);
    }
</script>