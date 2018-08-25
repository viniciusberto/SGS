@extends('layouts.layout')

@section('title')
    Cadastrar Dispositivo
@stop

@section('content')

    <form class="form-group row" method="POST" action="{{route('dispositivo.store')}}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="descricao">Descrição</label>
            <input class="form-control" type="text" name="descricao" required>
            <br>
            @if(Auth::user()->tipo != \App\User::TIPO_SOLICITANTE)
                <label for="empresa">Empresa</label>
                <select class="form-control" id="empresa" name="empresa" required>
                    <option value="">Selecione</option>
                    @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}">{{$empresa->nome}}</option>
                    @endforeach
                </select>
                <br>
            @endif
        </div>
        <div class="col-md-12">
            <button class="btn btn-success">Cadastrar</button>
        </div>
    </form>
@stop