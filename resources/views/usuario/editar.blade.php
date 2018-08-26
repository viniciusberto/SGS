@extends('layouts.layout')

@section('title')
    Editar Usuário
@stop

@section('content')
    @php
        use App\User;
    @endphp
    <form class="form-group row" method="POST" action="{{route('usuario.update', ['usuario' => $usuario])}}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="name">Nome</label>
            <input value="{{$usuario->name}}" class="form-control" type="text" name="name" required>
            <br>
        </div>
        <div class="col-md-12">
            <label for="email">Email</label>
            <input value="{{$usuario->email}}" class="form-control" type="text" name="email" required>
            <br>
        </div>

        <div class="col-md-4">
            <label for="tipo">Tipo</label>
            <select class="form-control" name="tipo" id="tipo" required>
                <option value="">Selecione</option>
                <option @if($usuario->tipo == User::TIPO_ADMIN) selected @endif value="{{User::TIPO_ADMIN}}">Administrador</option>
                <option @if($usuario->tipo == User::TIPO_TECNICO) selected @endif value="{{User::TIPO_TECNICO}}">Técnico</option>
                <option @if($usuario->tipo == User::TIPO_SOLICITANTE) selected @endif value="{{User::TIPO_SOLICITANTE}}">Solicitante</option>
            </select>
            <br>
        </div>
        <div class="col-md-4">
            <label for="empresa">Empresa</label>
            <select class="form-control" name="empresa_id" id="tipo" required>
                <option value="">Selecione</option>
                @foreach($empresas as $empresa)
                    <option @if($usuario->empresa_id == $empresa->id) selected @endif value="{{$empresa->id}}">{{$empresa->nome}}</option>
                @endforeach
            </select>
            <br>
        </div>

        <div class="col-md-4">
            <label for="senha">Senha</label>
            <input value="" min="6" class="form-control" id="senha" type="password" name="senha" placeholder="Coloque a sua senha">
            <br>
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Atualizar</button>
        </div>
    </form>
@stop