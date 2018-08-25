@extends('layouts.layout')

@section('title')
    Abrir Chamado
@stop

@section('content')
    <form class="form-group row" method="POST" action="{{route('chamado.store')}}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="titulo">Título</label>
            <input class="form-control" type="text" name="titulo" required>
            <br>
        </div>
        <div class="col-md-12">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" name="descricao" rows="5"></textarea>
            <br>
        </div>
        @if(Auth::user()->tipo == \App\User::TIPO_ADMIN)
            <div class="col-md-4">
                <label for="solicitante">Solicitante</label>
                <select class="form-control" required name="solicitante" id="solicitante">
                    <option value="">Selecione</option>
                    @foreach($solicitantes as $solicitante)
                        <option value="{{$solicitante->id}}">{{$solicitante->empresa}} | {{$solicitante->name}}</option>
                    @endforeach
                </select>
                <br>
            </div>
        @endif
        <div class="col-md-12">
            <button class="btn btn-success">Abrir</button>
        </div>
    </form>
@stop