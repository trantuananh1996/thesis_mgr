<div class="form-group">
    <label for="code" class="col-lg-2 col-sm-2 control-label">Mã lĩnh vực</label>
    <div class="col-lg-10">
        <input type="text" class="form-control" id="code" placeholder="" name="code">
    </div>
</div>
<div class="form-group">
    <label for="name" class="col-lg-2 col-sm-2 control-label">Tên lĩnh vực</label>
    <div class="col-lg-10">
        <input type="text" class="form-control" id="name" placeholder="" name="name">
    </div>
</div>
<div class="form-group">
    <label for="unit" class="col-lg-2 col-sm-2 control-label">Đơn vị</label>
    <div class="col-lg-10">
        <select class="form-control" id="unit" name="unit_id">
            {{--@cache($units)--}}
            @foreach($units as $unit)
                <option value="{{$unit->id}}">{{$unit->name}}</option>
            @endforeach
            {{--@endcache--}}
        </select>
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-lg-2 col-sm-2 control-label">Mô tả</label>
    <div class="col-lg-10">
                                <textarea class="form-control" name="description" id="description"
                                          placeholder="" rows="2"></textarea>
    </div>
</div>