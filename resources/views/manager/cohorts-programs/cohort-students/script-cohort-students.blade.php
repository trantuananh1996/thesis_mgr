<script type="text/javascript">
	function show_cohort_students(cohort_id,program_id,panel_id){
        url = 'cohorts-programs/show-cohort-students';

        $.ajax({
            url      : url,
            type     : "POST",
            data     : {
            				cohort_id: cohort_id,
            				program_id: program_id
                        },
            success  : function(data){
                    if(data.code != 200 && data.code != undefined)
                        alert(data.message);
                    else{
                        $('#'+panel_id).html(data);
                    }
            },
            error:function(){ 
                alert("Không thực hiện được hành động này!");    
            }
        });
	}
</script>