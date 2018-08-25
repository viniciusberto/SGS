@extends('layouts.layout')
@section('title')
    Listagem de Usuários
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('usuario.create')}}" class="btn btn-success">Adicionar Usuário</a>
        </div>
    </div>
    <br>
    <div class="row">
        @foreach($usuarios as  $usuario)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail listagem-card">
                    <div class="icone-listagem">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="caption container-fluid">
                        <h3>{{$usuario->name}}</h3>
                        <div class="col-md-12 sem-padding table-responsive">
                            <h4><b>Informações</b></h4>
                            <table class="table">
                                <tr>
                                    <td><label for="">Empresa: </label></td>
                                    <td>{{$usuario->empresa->nome}}</td>
                                </tr>
                                <tr>
                                    <td><label for="">Tipo:</label></td>
                                    <td>{{$usuario->tipoTexto}}</td>
                                </tr>
                            </table>

                        </div>
                        <div class="col-md-12 sem-padding">
                            <p class="listagem-card-bottom text-right">
                                <a href="{{route('usuario.edit', ['usuario' => $usuario])}}"
                                   class="btn btn-primary" role="button">Editar</a>
                                <a class="btn btn-success" role="button" data-toggle="modal"
                                   data-target="#modal{{$usuario->id}}">Detalhes</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div id="modal{{$usuario->id}}" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Informações do Usuário:</h4>
                            </div>
                            <div class="modal-body">
                                <p><b>Email:</b>{{$usuario->email}}</p>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-danger"
                                   href="{{route('usuario.destroy2',['id' => $usuario->id])}}">Excluir</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        @endforeach
    </div>
@stop