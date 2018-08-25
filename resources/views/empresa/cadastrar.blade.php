@extends('layouts.layout')

@section('title')
    Cadastrar Empresa
@stop

@section('content')

    <form class="form-group row" method="POST" action="{{route('empresa.store')}}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="nome">Nome</label>
            <input class="form-control" type="text" name="nome" required>
            <br>
        </div>
        <div class="col-md-3">
            <label for="tempo_">SLA</label>
            <select class="form-control" name="sla_id" id="sla_id" required>
                <option value="">Selecione</option>
                @foreach($slas as $sla)
                    <option value="{{$sla->id}}">{{$sla->nome}}</option>
                @endforeach
            </select>
            <br>
        </div>
        <div class="col-md-3">
            <label for="cnpj">CNPJ</label>
            <input class="form-control" type="text" name="cnpj" required>
            <br>
        </div>
        <div class="col-md-3">
            <label for="ie">IE</label>
            <input class="form-control" type="text" name="ie" required>
            <br>
        </div>
        <div class="col-md-3">
            <label for="telefone">Telefone</label>
            <input class="form-control" type="text" name="telefone" required>
            <br>
        </div>
        <div class="col-md-12">
            <label for="endereco">Edereço</label>
            <textarea class="form-control" name="endereco" required></textarea>
            <br>
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Cadastrar</button>
        </div>
    </form>
@stop