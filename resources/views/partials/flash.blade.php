@if(session()->has('flash_message'))
    <script>
        swal({
            title: "{{session('flash_message.title')}}",
            text: "{{session('flash_message.message')}}",
            type:  "{{session('flash_message.level')}}",
            timer: 1500,
            showConfirmButton: false
        }).then(
                function () {},
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                    }
                }
        );
        // handling the promise rejection;

    </script>
    {{session()->forget('flash_message')}}
@endif

@if(session()->has('flash_message_overlay'))
    <script>
        swal({
            title: "{{session('flash_message_overlay.title')}}",
            text: "{{session('flash_message_overlay.message')}}",
            type:  "{{session('flash_message_overlay.level')}}",
            confirmButtonText: 'Xác nhận'
        }).then(
                function () {},
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                    }
                }
        );

    </script>
    {{session()->forget('flash_message_overlay')}}
@endif