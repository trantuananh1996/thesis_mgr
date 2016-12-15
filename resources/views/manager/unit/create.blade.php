@extends('layouts.master')
@section('sidebar-menu')
    @include('partials.manager-sidebar')
@endsection
@section('top-menu-left')
    <h4>
        {!! Breadcrumbs::render('unit.create') !!}
    </h4>
@endsection
@section('content')
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thông tin đơn vị mới
            </header>
            <div class="panel-body">
                <div class="position-center">
                    {!!Form::open(['route' => 'unit.store','class'=>'form-horizontal','method'=>'post'])  !!}
                    <div class="form-group">
                        <label for="code" class="col-lg-2 col-sm-2 control-label">Mã đơn vị</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="code" placeholder="" name="code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-lg-2 col-sm-2 control-label">Tên đơn vị</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="name" placeholder="" name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-lg-2 col-sm-2 control-label">Mô tả</label>
                        <div class="col-lg-10">
                                <textarea class="form-control" name="description" id="description"
                                          placeholder="" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-primary">Tạo</button>
                            <button type="reset" class="btn btn-danger">Khởi tạo lại</button>
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