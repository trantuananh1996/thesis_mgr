 <script type="text/javascript">
        
        $("[id^='btn-delete-topic']").each(function(){
            $(this).click(function(){
                var id = $(this).attr('index');
                var run_function = function(){
                        $.ajax({
                            url      : 'topics/delete',
                            type     : "POST",
                            data     : {
                                        topic_id: id
                                       },
                            success  : function(data){
                                    if(data.code == 200){
                                        $('#topic-panel'+id).html('');
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
                confirm('Bạn chắc chắn muốn xóa đề tài này ?','warning',run_function);
            });
        });
        
        $("[id^='btn-change-locked']").each(function(){
            $(this).click(function(){
                var id = $(this).attr('index');
                
                $.ajax({
                    url      : 'topics/change-locked',
                    type     : "POST",
                    data     : {
                                topic_id: id
                               },
                    success  : function(data){
                            if(data.code == 200){
                                if(data.data == 1){
                                    $('#btn-change-locked'+id).attr('title',"Mở đăng ký");
                                    $('#btn-change-locked'+id).attr('class',"btn btn-danger");
                                    $('#btn-change-locked'+id).html('<i class="fa fa-lock"></i>');
                                }else{
                                    $('#btn-change-locked'+id).attr('title',"Khóa đăng ký");
                                    $('#btn-change-locked'+id).attr('class',"btn btn-info");
                                    $('#btn-change-locked'+id).html('<i class="fa fa-unlock"></i>');
                                }
                                alert(data.message,'','success');
                            }else{
                                alert(data.message,'','error');
                            }
                        },
                    error:function(){ 
                        alert('Có lỗi xảy ra, vui lòng thực hiện lại','','error');
                    }
                });
                
            });
        });

        $("[id^='btn-topic-tutors']").each(function(){
            $(this).click(function(){
                var id = $(this).attr('index');
                
                $.ajax({
                    url      : 'topics/show-connect-tutors',
                    type     : "POST",
                    data     : {
                                topic_id: id
                               },
                    success  : function(data){
                            if(data.code == undefined){
                                $('#tutors-topic-panel').html(data);
                            }else{
                                alert(data.message,'','error');
                            }
                        },
                    error:function(){ 
                        alert('Có lỗi xảy ra, vui lòng thực hiện lại','','error');
                    }
                });
                
            });
        });

        $("[id^='btn-topic-students-register']").each(function(){
            $(this).click(function(){
                var id = $(this).attr('index');
                $.ajax({
                    url      : 'topics/show-students-register',
                    type     : "POST",
                    data     : {
                                topic_id: id
                               },
                    success  : function(data){
                            if(data.code == undefined){
                                $('#students-register-topic-panel').html(data);
                            }else{
                                alert(data.message,'','error');
                            }
                        },
                    error:function(){ 
                        alert('Có lỗi xảy ra, vui lòng thực hiện lại','','error');
                    }
                });
                
            });
        });

</script>