@extends('layouts.master')
@section('head')
@endsection
@section('sidebar-menu')
    @include('partials.manager-sidebar')
@endsection
@section('top-menu-left')
    <h4>
        {!! Breadcrumbs::render('field.show',$field) !!}
    </h4>
@endsection
@section('content')

@endsection