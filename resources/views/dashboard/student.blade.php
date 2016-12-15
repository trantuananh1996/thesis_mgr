<div class="row">
    <div id="json" style="display: none">
        {{$json_fields}}
    </div>
    <div class="col-md-6">

    </div>
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading" style="text-align: center;">
                Các chủ đề theo lĩnh vực của {{$unit_name}}
            </div>
            <div class="panel-body">
                <div id="FlatTree4" class="tree tree-solid-line">
                    <div class = "tree-folder" style="display:none;">
                        <div class="tree-folder-header">
                            <i class="fa fa-folder"></i>
                            <div class="tree-folder-name"></div>
                        </div>
                        <div class="tree-folder-content"></div>
                        <div class="tree-loader" style="display:none"></div>
                    </div>
                    <div class="tree-item" style="display:none;">
                        <i class="tree-dot"></i>
                        <div class="tree-item-name"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

