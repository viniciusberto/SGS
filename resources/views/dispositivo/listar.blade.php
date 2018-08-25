@extends('layouts.layout')
@section('title')
    Listagem de Dispositivos
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('dispositivo.create')}}" class="btn btn-success">Adicionar Dispositivo</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dispositivos as  $dispositivo)
                    <tr>
                        <td>{{$dispositivo->empresa}}</td>
                        <td>{{$dispositivo->descricao}}</td>
                        <td>
                            <a href="{{route('dispositivo.edit',['dispositivo' => $dispositivo])}}"
                               class="btn btn-primary">Editar</a>
                            <a href="{{route('dispositivo.destroy2',['id' => $dispositivo->id])}}"
                               class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop