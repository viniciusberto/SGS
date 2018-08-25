@extends('layouts.layout')

@section('titulo')
Cadastrar Usuário
@stop

@section('conteudo')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Cadastrar Usuário</h1>
                <form method="POST" action="{{ route('registrar') }}">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="name">Nome</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Nome">

                            @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                            @if ($errors->has('email'))
                            <span class="invalid-feedback text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <select id="empresa" class="form-control" name="empresa" placeholder="Empresa">
                                <option value="">Empresa</option>
                                @if($empresas)
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}">{{$empresa->nome}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Senha">

                            @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmar Senha">
                        </div>

                        <div class="col-md-4">
                            <select id="tipo" name="tipo" class="form-control">
                                <option>Selecione um tipo</option>
                                <option>Administrador</option>
                                <option>Técnico</option>
                                <option>Solicitante</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Registrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
