@extends('layouts.layout')

@section('title')
    Cadastrar Produto
@stop

@section('content')

    <form class="form-group row" method="POST" action="{{route('produto.store')}}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="descricao">Nome</label>
            <input class="form-control" type="text" name="nome" required>
            <br>
        </div>
        <div class="col-md-4">
            <label for="tempo_">Valor</label>
            <input class="form-control" type="numeric" name="valor" required>
            <br>
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Cadastrar</button>
        </div>
    </form>
@stop