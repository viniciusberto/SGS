@extends('layouts.layout')

@section('title')
    Cadastrar Usuário
@stop

@section('content')
    @php
        use App\User;
    @endphp
    <form class="form-group row" method="POST" action="{{route('usuario.store')}}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="name">Nome</label>
            <input class="form-control" type="text" name="name" required>
            <br>
        </div>
        <div class="col-md-12">
            <label for="email">Email</label>
            <input class="form-control" type="text" name="email" required>
            <br>
        </div>

        <div class="col-md-4">
            <label for="tipo">Tipo</label>
            <select class="form-control" name="tipo" id="tipo" required>
                <option value="">Selecione</option>
                <option value="{{User::TIPO_ADMIN}}">Administrador</option>
                <option value="{{User::TIPO_TECNICO}}">Técnico</option>
                <option value="{{User::TIPO_SOLICITANTE}}">Solicitante</option>
            </select>
            <br>
        </div>
        <div class="col-md-4">
            <label for="empresa">Empresa</label>
            <select class="form-control" name="empresa_id" id="tipo" required>
                <option value="">Selecione</option>
                @foreach($empresas as $empresa)
                <option value="{{$empresa->id}}">{{$empresa->nome}}</option>
                @endforeach
            </select>
            <br>
        </div>

        <div class="col-md-4">
            <label for="senha">Senha</label>
            <input min="6" class="form-control" id="senha" type="password" name="senha" required>
            <br>
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Cadastrar</button>
        </div>
    </form>
@stop