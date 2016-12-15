<script src="{{URL::asset('js/tree.js')}}"></script>
<script>
    var fields = JSON.parse($("#json").text());
        var TreeView = function () {

        return {
            //main function to initiate the module
            init: function () {

                var DataSourceTree = function (options) {
                    this._data  = options.data;
                    this._delay = options.delay;
                };

                DataSourceTree.prototype = {

                    data: function (options, callback) {
                        callback({ data: options.data || this._data });
                    }
                };


                var dataSource = new DataSourceTree({
                    data: fields,
                    delay: 400
                });


                $('#FlatTree4').tree({
                    selectable: false,
                    dataSource: dataSource,
                    loadingHTML: '<img src="images/input-spinner.gif"/>',
                });


            }

        };

    }();
    $(document).ready(function () {
        TreeView.init();
    });
</script>
