@extends('layouts.layout')

@section('title')
    Cadastrar Prioridade
@stop

@section('content')

    <form class="form-group row" method="POST" action="{{route('prioridade.store')}}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="descricao">Descrição</label>
            <input class="form-control" type="text" name="descricao" required>
            <br>
        </div>
        <div class="col-md-6">
            <label for="tempo_">Tempo de Atendimento em Min</label>
            <input min="0" class="form-control" type="number" name="tempo_atendimento" required>
            <br>
        </div>
        <div class="col-md-6">
            <label for="tempo">Tempo de Resolução em Min</label>
            <input min="0" class="form-control" type="number" name="tempo_resolucao" required>
            <br>
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Cadastrar</button>
        </div>
    </form>
@stop