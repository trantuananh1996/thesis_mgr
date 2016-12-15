<script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Cache-Control': 'no-cache',
            'Pragma': 'no-cache'
        }
    });

    $("#datepicker").datepicker({
        showAnim: "drop",
        dateFormat: "dd-mm-yyyy",
        yearRange: "1930:2020",
        changeMonth: true,
        changeYear: true,
    });

    $('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });

    $(".form_datetime").datepicker({
        showAnim: "drop",
        format: "dd-mm-yyyy",
        yearRange: "1930:2020",
        changeMonth: true,
        changeYear: true
    });

    function file_change(f, img_id) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.getElementById(img_id);
            img.src = e.target.result;
            img.style.display = "inline";
        };
        reader.readAsDataURL(f.files[0]);
    }

    function load_check_box_dataTable(table_id, row_id_form, index_id_form, check_box_id, value_tag_id) {
        var checkeds = [];

        $("[id^='" + row_id_form + "']").each(function () {
            $(this).click(function () {
                if ($(this).attr('click') == 0) {
                    $(this).attr('click', 1);
                    $('#' + check_box_id + $(this).attr(index_id_form)).prop('checked', true);
                    $('#' + check_box_id + $(this).attr(index_id_form)).attr('checked', true);
                    checkeds.push($(this).attr(index_id_form) + '');
                    $(this).attr('style', 'background-color:#F5A9A9; color:white');
                } else {
                    $(this).attr('click', 0);
                    $('#' + check_box_id + $(this).attr(index_id_form)).removeAttr('checked');

                    index = checkeds.indexOf($(this).attr(index_id_form) + '');
                    if (index >= 0) {
                        checkeds.splice(index, 1);
                    }
                    $(this).attr('style', '');
                }
                $('#' + value_tag_id).attr('value', checkeds);
            });
        });

        var table = $('#' + table_id).DataTable({
            responsive: true,
            language: {
                "sProcessing": "Đang xử lý...",
                "sLengthMenu": "Xem _MENU_ ",
                "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                "sInfo": "",
                "sInfoEmpty": "",
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
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [[1, 'asc']]
        });

        table.columns().every( function () {
            var that = this;
     
            $('input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();

        return table;


    }

    function initDataTable($table) {
        var table = $table.DataTable({
            responsive: true,
            lengthMenu: [[5, 10, 20, -1], [5, 10, 20, "All"]],
            bLengthChange: true,
            bSort: false,
            iDisplayLength: 10,
            "oLanguage": {
                "sProcessing": "Đang xử lý...",
                "sLengthMenu": "Xem _MENU_ bản ghi",
                "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
                "sInfo": "Đang xem _START_ tới _END_ của _TOTAL_ bản ghi",
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
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [[1, 'asc']]
        });

        table.columns().every( function () {
            var that = this;
     
            $('input', this.header() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            });
        }).draw();

        return table;

    }
    function confirmDelete(url, alert) {
        if (arguments[0] != null) {
            swal({
                text: alert,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-fw"></i> Xác nhận',
                cancelButtonText: '<i class="fa fa-times fa-fw"></i>Hủy xóa',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(function () {
                location.href = url;
            }, function (dismiss) {
                if (dismiss === 'cancel') {
                    return false;
                }
            });

            return false;
        }
        else {
            return false;
        }
    }

    function confirm(alert,type,run_function){
        if(type === undefined){
            type = 'info';
        }
        if (arguments[0] != null) {
            swal({
                text: alert,
                type: type,
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check fa-fw"></i> Có',
                cancelButtonText: '<i class="fa fa-times fa-fw"></i>Không',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false
            }).then(run_function, 
                    function (dismiss) {
                    if (dismiss === 'cancel') {
                        return false;
                    }
                });

            return false;
        }
        else {
            return false;
        }
    }

    function alert(text,title, type) {
        if (type === undefined) {
            type = 'info'
        }
        if (title === undefined){
            title = '';
        }
        swal({
            title: title,
            text: text,
            type: type,
            timer: 1500,
            showConfirmButton: false
        }).then(
                function () {
                },
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                    }
                }
        );
        // handling the promise rejection;
    }
</script>