@extends('layouts.layout')

@section('title')
    {{$title}}
@endsection
@section('header-commands')
    <a href="{{route($route.'.create')}}" class="btn btn-success page-header-comand">{{$action}}</a>
@stop


@section('content')
    @include('components.table')
@stop