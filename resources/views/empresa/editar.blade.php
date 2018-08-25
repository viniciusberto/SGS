@extends('layouts.layout')

@section('title')
    Editar Empresa
@stop

@section('content')

    <form class="form-group row" method="POST" action="{{route('empresa.update',['empresa' => $empresa])}}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="nome">Nome</label>
            <input class="form-control" type="text" name="nome" required value="{{$empresa->nome}}">
            <br>
        </div>
        <div class="col-md-3">
            <label for="tempo_">SLA</label>
            <select class="form-control" name="sla_id" id="sla_id" required>
                <option value="">Selecione</option>
                @foreach($slas as $sla)
                    <option @if($empresa->sla_id == $sla->id) selected @endif value="{{$sla->id}}">{{$sla->nome}}</option>
                @endforeach
            </select>
            <br>
        </div>
        <div class="col-md-3">
            <label for="cnpj">CNPJ</label>
            <input class="form-control" type="text" name="cnpj" required value="{{$empresa->cnpj}}">
            <br>
        </div>
        <div class="col-md-3">
            <label for="ie">IE</label>
            <input class="form-control" type="text" name="ie" required value="{{$empresa->ie}}">
            <br>
        </div>
        <div class="col-md-3">
            <label for="telefone">Telefone</label>
            <input class="form-control" type="text" name="telefone" required value="{{$empresa->telefone}}">
            <br>
        </div>
        <div class="col-md-12">
            <label for="endereco">Edereço</label>
            <textarea class="form-control" name="endereco" required>{{$empresa->endereco}}</textarea>
            <br>
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Atualizar</button>
        </div>
    </form>
@stop