<script type="text/javascript">
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
                                    $('#topic-row'+id).remove();
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

    $("[id^='btn-denies-student-learn']").each(function(){
        $(this).click(function(){
            var id = $(this).attr('index');
            var run_function = function(){
                $.ajax({
                        url      : 'denies-student-learn',
                        type     : "POST",
                        data     : {
                                    topic_id: {{$topic->id}},
                                    student_topic_id: id
                                   },
                        success  : function(data){
                                if(data.code == 200){
                                    $('#student-learn'+id).remove();
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
            confirm('Bạn chắc chắn muốn đình chỉ sinh viên này làm khóa luận?','warning',run_function);
        });
    });

     $("[id^='btn-accept-student-protected']").each(function(){
        $(this).click(function(){
            var id = $(this).attr('index');
            var run_function = function(){
                $.ajax({
                        url      : 'accept-student-protected',
                        type     : "POST",
                        data     : {
                                    topic_id: {{$topic->id}},
                                    student_topic_id: id
                                   },
                        success  : function(data){
                                if(data.code == 200){
                                    $('#btn-accept-student-protected'+id).replaceWith('<p class="text text-info"><b>Được bảo vệ<b></p>');
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
            confirm('Bạn đồng ý cho sinh viên này được bảo vệ khóa luận?','warning',run_function);
        });
    });


</script>