<script type="text/javascript">
	$("[id^='btn-register']").each(function(){
            $(this).click(function(){
                var id = $(this).attr('index');
                var run_function = function(){
                        $.ajax({
                            url      : 'topics/register',
                            type     : "POST",
                            data     : {
                                        topic_id: id
                                       },
                            success  : function(data){
                                    if(data.code == 200){
                                        $('#topic_student_footer'+id).html('<p class="text text-primary">CHỜ PHÊ DUYỆT ...</p> ');
                                        alert(data.message,'','success');
                                    }else{
                                        alert(data.message,'','error');
                                    }
                                },
                            error:function(){ 
                                alert('Có lỗi xảy ra, vui lòng thực hiện lại','','error');
                            }
                        });
                    };
                confirm('Bạn chắc chắn muốn đăng ký đề tài này ?','warning',run_function);
            });
        });
</script>