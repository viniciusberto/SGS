@extends('layouts.layout')
@section('title')
    Classificação Inicial
@stop
@section('content')
    <div class="row">
        <div class="col-md-12 table-responsive">
            <div class="list-group">
                @foreach($chamados as $chamado)
                    @php
                        $h = intval(date('H',strtotime($chamado->tempo)));
                        $m = intval(date('i',strtotime($chamado->tempo)));
                        $s = intval(date('s',strtotime($chamado->tempo)));
                        $res;
                        if ($h == 0 && $m == 0 && $s == 0){
                            $res = 'danger';
                        }else{
                            if ($m < 15 && $m > 0){
                                $res = 'warning';
                            }else{
                                $res = 'success';
                            }
                        }
                    @endphp
                    <div id="chamado-{{$chamado->id}}"
                         class="list-group-item list-group-item-{{$res}} col-md-12 item-listagem">
                        <div class="col-md-6 sem-padding">
                            <h4 class="list-group-item-heading">{{$chamado->titulo}}</h4>
                            <p class="list-group-item-text">{{$chamado->descricao}}</p><br>
                        </div>
                        <div class="col-md-6 sem-padding">
                            <div class="col-md-5 sem-padding">
                                <p>{{$chamado->empresa}}</p>
                                <p>{{$chamado->solicitante}}</p>
                            </div>
                            <br>
                            <div class="col-md-7 text-right sem-padding">
                                <button class="botao-trocar btn btn-{{$res}}" data-toggle="modal"
                                        data-target="#modal-{{$chamado->id}}">Classificar
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-{{$chamado->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <form method="POST" action="{{route('chamado.atualizar',[
                        'sts' => \App\Chamado::STATUS_ABERTO, 'id' => $chamado->id])}}">
                            {{csrf_field()}}

                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header sem-padding-bottom">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                    aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">{{$chamado->titulo}}</h4>
                                        <p>{{$chamado->empresa}}</p>
                                    </div>
                                    <div class="col-md-12 modal-body">
                                        <div class="col-md-9 sem-padding">
                                            <p>
                                                <label>Data Abertura: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$chamado->data_abertura}}"
                                                       disabled>
                                            </p>
                                        </div>
                                        <div data-id="{{$chamado->id}}" data-limite="{{$chamado->limite_aceitacao}}"
                                             class="tempo col-md-3 sem-padding text-center"
                                             id="tempo-restante">
                                            <strong>TEMPO RESTANTE</strong><br>
                                            <span id="texto">{{$chamado->tempo}}</span>
                                        </div>
                                        <div class="col-md-12 sem-padding">
                                            <p>
                                                <label>Limite de Aceitação:</label>
                                                <input class="form-control" type="text"
                                                       value="{{$chamado->limite_aceitacao}}" disabled>
                                            </p>
                                            <p>
                                                <label>Solicitante: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$chamado->solicitante}}"
                                                       disabled>
                                            </p>
                                            <p>
                                                <a class="botao-mais-sm" href="{{route('dispositivo.create')}}">
                                                    <i class="fa fa-plus-square"></i>
                                                </a>
                                                <label for="dispositivo">Dispositivo</label>
                                                <select class="form-control" name="dispositivo" id="dispositivo"
                                                        required>
                                                    <option value="">Selecione</option>
                                                    @foreach($dispositivos as $dispositivo)
                                                        <option value="{{$dispositivo->id}}">{{$dispositivo->descricao}}</option>
                                                    @endforeach
                                                </select>
                                            </p>
                                        </div>
                                        <div class="col-md-12 sem-padding">
                                            <p>
                                                <a class="botao-mais-sm"
                                                   href="{{route('sla.edit',['id' => $chamado->sla->id])}}">
                                                    <i class="fa fa-plus-square"></i>
                                                </a>
                                                <label for="prioridade">Prioridade</label>
                                                <select class="form-control" name="prioridade" id="prioridade" required>
                                                    <option value="">Selecione</option>
                                                    @foreach($prioridades as $prioridade)
                                                        <option value="{{$prioridade->id}}">{{$prioridade->descricao}}</option>
                                                    @endforeach
                                                </select>
                                            </p>
                                        </div>
                                        <div class="col-md-12 sem-padding">
                                            <br>
                                            <label>Descrição:</label>
                                            <textarea class="form-control" name="descricao" id="descricao"
                                                      rows="4" disabled>{{$chamado->descricao}}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar
                                        </button>
                                        <button class="botao-trocar btn btn-{{$res}}">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop