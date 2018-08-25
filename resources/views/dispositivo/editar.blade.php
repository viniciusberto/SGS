@extends('layouts.layout')

@section('title')
    Atualizar Dispositivo
@stop

@section('content')

    <form class="form-group row" method="POST" action="{{route('dispositivo.update',['dispositivo' => $dispositivo])}}">
        {{method_field('PUT')}}
        {{ csrf_field() }}

        <div class="col-md-12">
            <label for="descricao">Descrição</label>
            <input class="form-control" type="text" name="descricao" required value="{{$dispositivo->descricao}}">
            <br>
        </div>
        <div class="col-md-12">
            <button class="btn btn-success">Atualizar</button>
        </div>
    </form>
@stop