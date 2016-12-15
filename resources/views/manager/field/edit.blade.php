@extends('layouts.master')
@section('head')
    <link href="{{asset('css/dataTable.css')}}" rel="stylesheet"/>

@endsection
@section('sidebar-menu')
    @include('partials.manager-sidebar')
@endsection
@section('top-menu-left')
    <h4>
        {!! Breadcrumbs::render('field.edit',$field) !!}
    </h4>
@endsection
@section('content')
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
               Thông tin lĩnh vực
            </header>
            <div class="panel-body">
                <div class="position-center">
                    {!!Form::open(['route' => ['field.update',$field->slug],'class'=>'form-horizontal','method'=>'put'])  !!}
                    <div class="form-group">
                        <label for="code" class="col-lg-2 col-sm-2 control-label">Mã lĩnh vực</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="code" placeholder="" name="code" value="{{$field->code}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-lg-2 col-sm-2 control-label">Tên lĩnh vực</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="name" placeholder="" name="name" value="{{$field->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="unit" class="col-lg-2 col-sm-2 control-label">Đơn vị</label>
                        <div class="col-lg-10">
                            <select class="form-control" id="unit" name="unit_id">
                                @foreach($units as $unit)
                                    @if($field->unit_id == $unit->id)
                                    <option value="{{$unit->id}}" selected>{{$unit->name}}</option>
                                    @else
                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
                                        @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-lg-2 col-sm-2 control-label">Mô tả</label>
                        <div class="col-lg-10">
                                <textarea class="form-control" name="description" id="description"
                                          placeholder="" rows="2" >{{$field->description}}</textarea>
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