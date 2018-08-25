@extends('layouts.layout')
@section('title')
    Listagem de Empresas
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('empresa.create')}}" class="btn btn-success">Adicionar Nova Empresa</a>
        </div>
    </div>
    <br>
    <div class="row">
        @foreach($empresas as $empresa)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail listagem-card">
                    <div class="icone-listagem">
                        <i class="fa fa-industry fa-5x"></i>
                    </div>
                    <div class="caption container-fluid">
                        <h3>{{$empresa->nome}}</h3>
                        <div class="col-md-12 sem-padding table-responsive">

                            <h4><b>Informações</b></h4>

                            <label for="">Telefone: </label>
                                {{$empresa->telefone}}<br>
                            <label for="">Endereço:</label>
                                {{$empresa->endereco}}
                        </div>
                        <div class="col-md-12 sem-padding">
                            <p class="listagem-card-bottom text-right">
                                <a href="{{route('empresa.edit', ['empresa' => $empresa])}}" class="btn btn-primary"
                                   role="button">Editar</a>
                                <a class="btn btn-success" role="button" data-toggle="modal"
                                   data-target="#modal{{$empresa->id}}">Detalhes</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal{{$empresa->id}}" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Detalhes da SLA</h4>
                        </div>
                        <div class="modal-body">
                            <p><b>Funcionários desta empresa:</b></p>
                            @forelse($empresa->funcionarios as $funcionario)
                                <p>
                                    <a href="{{route('usuario.edit',array('id' => $funcionario->id))}}">{{$funcionario->name}}</a>
                                </p>
                            @empty
                                <p>Nenhum funcionário está cadastrado com essa Empresa</p>
                            @endforelse
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger" href="{{route('empresa.destroy2',['id' => $empresa->id])}}">Excluir</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        @endforeach
    </div>
@stop