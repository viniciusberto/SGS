@extends('layouts.layout')
@section('title')
    Listagem de Produtos
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('produto.create')}}" class="btn btn-success">Adicionar Produto</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table">
                <thead>
                <th>Nome</th>
                <th>Valor</th>
                <th>Ações</th>
                </thead>
                <tbody>
                @foreach($produtos as  $produto)
                    <tr>
                        <td>{{$produto->nome}}</td>
                        <td>{{$produto->valor}}</td>
                        <td>
                            <a href="{{route('produto.edit',['produto' => $produto])}}" class="btn btn-primary">Editar</a>
                            <a href="{{route('produto.destroy2',['id' => $produto->id])}}"
                               class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop