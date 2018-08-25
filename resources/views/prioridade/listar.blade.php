@extends('layouts.layout')
@section('title')
    Listagem de Prioridades
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('prioridade.create')}}" class="btn btn-success">Adicionar Prioridade</a>
        </div>
    </div>
    <br>
    <div class="row">
        @foreach($prioridades as  $prioridade)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail listagem-card">
                    <div class="icone-listagem">
                        <i class="fa fa-flag-checkered fa-5x"></i>
                    </div>
                    <div class="caption container-fluid">
                        <h3>{{$prioridade->descricao}}</h3>
                        <div class="col-md-12 sem-padding table-responsive">
                            <h4><b>Tempos</b></h4>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Descricao</th>
                                    <th class="text-center">min</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Tempo de Atendimento</td>
                                    <td class="text-center">{{$prioridade->tempo_atendimento}}</td>
                                </tr>
                                <tr>
                                    <td>Tempo de Resolução</td>
                                    <td class="text-center">{{$prioridade->tempo_resolucao}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 sem-padding">
                            <p class="listagem-card-bottom text-right">
                                <a href="{{route('prioridade.edit', ['prioridade' => $prioridade])}}"
                                   class="btn btn-primary" role="button">Editar</a>
                                <a class="btn btn-success" role="button" data-toggle="modal"
                                   data-target="#modal{{$prioridade->id}}">Detalhes</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div id="modal{{$prioridade->id}}" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Detalhes da SLA</h4>
                            </div>
                            <div class="modal-body">
                                <p><b>SLA's com essa prioridade:</b></p>
                                @forelse($prioridade->slas as $sla)
                                    <p>
                                        <a href="{{route('sla.edit',array('id' => $sla->id))}}">{{$sla->nome}}</a>
                                    </p>
                                @empty
                                    <p>Nenhuma SLA está utilizando esta prioridade</p>
                                @endforelse
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-danger"
                                   href="{{route('prioridade.destroy2',['id' => $prioridade->id])}}">Excluir</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
        @endforeach
    </div>
@stop