@extends('layouts.layout')
@section('title')
    Chamados Fechados
@stop
@section('content')
    @php
        use App\User;
    @endphp
    <div class="row">
        <div class="col-md-12 table-responsive">
            <div class="list-group">
                @foreach($chamados as $chamado)
                    <?php
                    date_default_timezone_set('UTC');
                    $data_abertura = strtotime($chamado->data_abertura);
                    $data_aceitacao = strtotime($chamado->data_aceitacao);
                    $data_fechamento = strtotime($chamado->data_fechamento);
                    $limite_aceitacao = strtotime($chamado->limite_aceitacao) - $data_abertura;
                    $limite_resolucao = strtotime($chamado->limite_resolucao) - $data_aceitacao;

                    $aceitacao = $data_aceitacao - $data_abertura;
                    $resolucao = $data_fechamento - $data_aceitacao;
                    $excedeu = '';
                    if ($limite_aceitacao - $aceitacao > 0) {
                        if ($limite_resolucao - $resolucao > 0) {
                            $res = 'success';
                            $aceitacao = $limite_aceitacao - $aceitacao;
                            $resolucao = $limite_resolucao - $resolucao;

                            $ha = intval(date('H', $aceitacao));
                            $ma = intval(date('i', $aceitacao));
                            $sa = intval(date('s', $aceitacao));

                            $hr = intval(date('H', $resolucao));
                            $mr = intval(date('i', $resolucao));
                            $sr = intval(date('s', $resolucao));

                            if ($ha == 0 && $ma < 15 && $ma >= 0 && $sa > 0)
                                $res = 'warning';
                            if ($hr == 0 && $mr < 15 && $mr >= 0 && $sr > 0)
                                $res = 'warning';

                        } else {
                            $excedeu = 'Excedeu o limite de resolucao!';
                            $res = 'warning';
                        }
                    } else {
                        if ($limite_resolucao - $resolucao > 0) {
                            $excedeu = 'Excedeu o limite de aceitacao!';
                            $res = 'warning';
                        }else{
                        $excedeu = 'Excedeu o limite de aceitacao e resolução!';
                            $res = 'danger';
                        }

                    }
                    date_default_timezone_set('America/Campo_Grande');
                    ?>
                    <div id="chamado-{{$chamado->id}}"
                         class="list-group-item list-group-item-{{$res}} col-md-12 item-listagem">
                        <div class="col-md-12 sem-padding">
                            <h4 style="border-bottom: 1px solid;"
                                class="list-group-item-heading">{{$chamado->titulo}}</h4>
                        </div>
                        <div class="col-md-6 sem-padding">
                            <p class="list-group-item-text">{{$chamado->descricao}}</p><br>
                        </div>
                        <div class="col-md-6 sem-padding">
                            <div class="col-md-5 sem-padding">
                                <p><b>Empresa: </b>{{$chamado->empresa}}</p>
                                <p><b>Solicitante: </b>{{$chamado->solicitante}}</p>
                                <p><b>Técnico: </b>{{$chamado->tecnico}}</p>
                            </div>
                            <br>
                            <div class="col-md-7 text-right sem-padding">
                                <button class="botao-trocar btn btn-{{$res}}" data-toggle="modal"
                                        data-target="#modal-{{$chamado->id}}">Detalhes
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modal-{{$chamado->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <form @if(Auth::user()->tipo != User::TIPO_SOLICITANTE) method="POST" action="{{route('chamado.atualizar',[
                        'sts' => \App\Chamado::STATUS_FECHADO, 'id' => $chamado->id])}}" @endif>
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
                                        <div
                                                class="tempo col-md-3 sem-padding text-center"
                                                id="tempo-restante">
                                            <strong>TEMPO GASTO</strong><br>
                                            <span id="texto">{{$chamado->tempo_total}}</span><br>
                                            <strong>NO CHAMADO</strong>
                                            <strong class="alert-danger">{{$excedeu}}</strong>

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

                                                <label>Dispositivo: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$chamado->equipamento}}"
                                                       disabled>

                                            </p>
                                        </div>
                                        <div class="col-md-6 sem-padding-esquerdo">
                                            <p>
                                                <label>Tempo de Aceitação: </label>
                                                <input class="form-control" type="text"
                                                       value="@php
                                                           $hr = intval($chamado->prioridade->tempo_atendimento/60);
                                                            $min = $chamado->prioridade->tempo_atendimento%60;
                                                            $str = '';
                                                       if ($hr > 1){
                                                           $str = $str.$hr.' Horas';
                                                           if ($min > 0){
                                                               $str = $str.' e ';
                                                           }
                                                       }
                                                       if ($hr == 1){
                                                           $str = $str.$hr.' Hora';
                                                           if ($min > 0){
                                                               $str = $str.' e ';
                                                           }
                                                       }
                                                       if ($min > 1){
                                                            $str = $str.$min.' minutos';
                                                            }
                                                       if ($min == 1){
                                                            $str = $str.$min.' minuto';
                                                            }
                                                       echo trim($str);
                                                       @endphp"
                                                       disabled>
                                            </p>
                                            <p>
                                                <label>Tempo de Resolução: </label>
                                                <input class="form-control" type="text"
                                                       value="@php
                                                           $hr = intval($chamado->prioridade->tempo_resolucao/60);
                                                            $min = $chamado->prioridade->tempo_resolucao%60;
                                                            $str = '';
                                                       if ($hr > 1){
                                                           $str = $str.$hr.' Horas';
                                                           if ($min > 0){
                                                               $str = $str.' e ';
                                                           }
                                                       }
                                                       if ($hr == 1){
                                                           $str = $str.$hr.' Hora';
                                                           if ($min > 0){
                                                               $str = $str.' e ';
                                                           }
                                                       }
                                                       if ($min > 1){
                                                            $str = $str.$min.' minutos';
                                                            }
                                                       if ($min == 1){
                                                            $str = $str.$min.' minuto';
                                                            }
                                                       echo trim($str);
                                                       @endphp"
                                                       disabled>
                                            </p>
                                        </div>
                                        <div class="col-md-6 sem-padding">
                                            <p>
                                                <label>Prioridade: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$chamado->prioridade->descricao}}"
                                                       disabled>
                                            </p>
                                            <p>
                                                <label>Técnico: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$chamado->tecnico}}"
                                                       disabled>
                                            </p>
                                        </div>
                                        <div class="col-md-12 sem-padding">
                                            <label for="obs">Observações:</label>
                                            <textarea class="form-control" name="obs" id="obs"
                                                      rows="2" disabled>{{$chamado->obs}}</textarea>
                                        </div>
                                        <div class="col-md-12 sem-padding">
                                            <label>Descrição:</label>
                                            <textarea class="form-control" name="descricao" id="descricao"
                                                      rows="4" disabled>{{$chamado->descricao}}</textarea>
                                        </div>

                                        <div class="col-md-12 sem-padding">
                                            <p>
                                                <label>Problema Real: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$chamado->problema}}"
                                                       required disabled>
                                            </p>
                                            <p>
                                                <label>Solução: </label>
                                                <input class="form-control" type="text"
                                                       value="{{$chamado->solucao}}"
                                                       required disabled>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Voltar
                                        </button>
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