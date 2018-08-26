
@extends('layouts.login')

@section('titulo')
Login
@stop

@section('content')
<div class="container" style="min-height: calc(100vh - 51px)!important;">
    <div class="card centro col-md-4">
        <div class="card-body">
            <img class="img-login img-responsive" src="/imagens/logo.png">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-12">
                        <input placeholder="Usuário" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input placeholder="Senha" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="form-control btn btn-success">
                            {{ __('Entrar') }}
                        </button>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Esqueceu a senha?') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
