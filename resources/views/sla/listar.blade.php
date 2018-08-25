@extends('layouts.layout')

@section('title')
    Listagem de SLA's
@stop


@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{route('sla.create')}}" class="btn btn-success">Adicionar Nova SLA</a>
        </div>
    </div>
    <br>
    <div class="row">
        @foreach($slas as $sla)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail listagem-card">
                    <b>{{count($sla->empresas)}}</b>
                    <div class="icone-listagem">
                        <i class="far fa-clock fa-5x"></i>
                    </div>
                    <div class="caption container-fluid">
                        <h3>{{$sla->nome}}</h3>


                        <div class="col-md-12 sem-padding table-responsive">

                            <h4><b>Prioridades</b></h4>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Descricao</th>
                                    <th class="text-center">T.A</th>
                                    <th class="text-center">T.R</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sla->prioridades as $prioridade)
                                    <tr>
                                        <td>{{$prioridade->descricao}}</td>
                                        <td class="text-center">{{$prioridade->tempo_atendimento}}</td>
                                        <td class="text-center">{{$prioridade->tempo_resolucao}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 sem-padding">
                            <p class="listagem-card-bottom text-right">
                                <a href="{{route('sla.edit', ['sla' => $sla])}}" class="btn btn-primary" role="button">Editar</a>
                                <a class="btn btn-success" role="button" data-toggle="modal"
                                   data-target="#modal{{$sla->id}}">Detalhes</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div id="modal{{$sla->id}}" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Detalhes da SLA</h4>
                        </div>
                        <div class="modal-body">
                            <p><b>Empresas com essa sla:</b></p>
                            @forelse($sla->empresas as $empresa)
                                <p><a href="{{route('empresa.edit',array('id' => $empresa->id))}}">{{$empresa->nome}}</a></p>
                            @empty
                                <p>Nenhuma empresa está utilizando esta SLA</p>
                            @endforelse
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-danger" href="{{route('sla.destroy2',['id' => $sla->id])}}">Excluir</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        @endforeach
    </div>
@stop