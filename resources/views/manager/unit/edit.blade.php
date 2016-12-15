@extends('layouts.master')
@section('sidebar-menu')
    @include('partials.manager-sidebar')
@endsection
@section('top-menu-left')
    <h4>
        {!! Breadcrumbs::render('unit.edit',$unit) !!}
    </h4>
@endsection
@section('content')
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thông tin của đơn vị
            </header>
            <div class="panel-body">
                <div class="position-center">
                    {!!Form::open(['route' => ['unit.update',$unit->slug],'class'=>'form-horizontal','method'=>'put'])  !!}
                    <div class="form-group">
                        <label for="code" class="col-lg-2 col-sm-2 control-label">Mã đơn vị</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="code" placeholder="" name="code" value="{{$unit->code}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-lg-2 col-sm-2 control-label">Tên đơn vị</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="name" placeholder="" name="name" value="{{$unit->name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-lg-2 col-sm-2 control-label">Mô tả</label>
                        <div class="col-lg-10">
                                <textarea class="form-control" name="description" id="description"
                                          placeholder="" rows="4">{{$unit->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </section>

    </div>
@endsection
@section('page-script')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection