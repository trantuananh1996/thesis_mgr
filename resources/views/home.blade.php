@extends('layouts.master')

@section('head')
    <link href="{{asset('css/dataTable.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/tree.css')}}" rel="stylesheet"/>

@endsection
@section('sidebar-menu')
    @include('partials.manager-sidebar')
@endsection
@section('top-menu-left')
    <h4>
        DANH SÁCH LĨNH VỰC - ĐỀ TÀI
    </h4>
@endsection
@section('content')
    @if(Auth::user()->hasRole('SV'))
        @include('dashboard.student')
    @endif
@endsection
@section('page-script')
    @if(Auth::user()->hasRole('SV'))
        @include('dashboard.student-script')
    @endif
@endsection