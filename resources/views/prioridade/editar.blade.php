@extends('layouts.layout')

@section('title')
    Editar Prioridade
@stop

@section('content')
    <form method="POST" action="{{route('prioridade.update',['prioridade' => $prioridade])}}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="col-md-12">
            <label for="descricao">Descrição</label>
            <input value="{{$prioridade->descricao}}" class="form-control" type="text" name="descricao" required>
            <br>
        </div>
        <div class="col-md-6">
            <label for="tempo_">Tempo de Atendimento em Min</label>
            <input value="{{$prioridade->tempo_atendimento}}" min="0" class="form-control" type="number" name="tempo_atendimento" required>
            <br>
        </div>
        <div class="col-md-6">
            <label for="tempo">Tempo de Resolução em Min</label>
            <input value="{{$prioridade->tempo_resolucao}}" min="0" class="form-control" type="number" name="tempo_resolucao" required>
            <br>
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Atualizar</button>
        </div>
    </form>
@stop