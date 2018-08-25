@extends('layouts.layout')

@section('title')
    Editar Produto
@stop

@section('content')

    <form class="form-group row" method="POST" action="{{route('produto.update',['produto'=>$produto])}}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="col-md-12">
            <label for="descricao">Nome</label>
            <input class="form-control" type="text" name="nome" required value="{{$produto->nome}}">
            <br>
        </div>
        <div class="col-md-4">
            <label for="tempo_">Valor</label>
            <input class="form-control" type="numeric" name="valor" required value="{{$produto->valor}}">
            <br>
        </div>

        <div class="col-md-12">
            <button class="btn btn-success">Atualizar</button>
        </div>
    </form>
@stop