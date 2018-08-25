@extends('layouts.layout')

@section('title')
    Cadastrar SLA
@stop

@section('content')

    <form class="form-group row" method="POST" action="{{route('sla.store')}}">
        {{ csrf_field() }}
        <div class="col-md-12">
            <label for="nome">Nome</label>
            <input class="form-control" type="text" name="nome" id="nome" placeholder="Nome da SLA" required>
            <br>
        </div>
        @if($agent->isMobile())
            <div class="col-md-12">
                <a class="botao-mais-flr position-absolute" href="{{route('prioridade.create')}}">
                    <i class="fa fa-plus-square"></i>
                </a>
                <label for="lista-geral">Prioridades</label>
                <ul class="list-group lista-enviar">
                    @foreach($prioridades as $prioridade)
                        <li data-id="{{$prioridade->id}}" class="list-group-item c-lista_drag-item">
                        <span class="c-lista_drag-item-span-60">
                            <input id="check-{{$prioridade->id}}" type="checkbox" value="check-{{$prioridade->id}}">
                        <label for="check-{{$prioridade->id}}">{{$prioridade->descricao}}</label>
                        </span>
                            <span class="c-lista_drag-item-span-20 text-center" data-toggle="tooltip"
                                  title="Tempo de Atendimento"><b>T.A: </b>{{$prioridade->tempo_atendimento}}
                        </span>
                            <span class="c-lista_drag-item-span-20 text-center" data-toggle="tooltip"
                                  title="Tempo de Resolução"><b>T.R: </b>{{$prioridade->tempo_resolucao}}
                        </span>
                        </li>
                    @endforeach

                </ul>
            </div>
        @else
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <label for="lista-enviar">Prioridades desta SLA</label>
                        <ul data-toggle="popover" title="Aviso" data-content="" id="sortable1" style="min-height: 20px;"
                            class="list-group lista-enviar sem-margin-bottom connectedSortable">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a class="botao-mais-flr position-absolute" href="{{route('prioridade.create')}}">
                            <i class="fa fa-plus-square"></i>
                        </a>
                        <label for="lista-geral">Todas as Prioridades Cadastradas</label>
                        <ul id="sortable2" style="min-height: 20px;"
                            class="list-group sem-margin-bottom connectedSortable">
                            @foreach($prioridades as $prioridade)
                                <li data-id="{{$prioridade->id}}" class="list-group-item c-lista_drag-item">
                                    <span class="c-lista_drag-item-span-60" data-toggle="tooltip"
                                          title="Descrição">{{$prioridade->descricao}}</span>
                                    <span class="c-lista_drag-item-span-20 text-center" data-toggle="tooltip"
                                          title="Tempo de Atendimento"><b>T.A: </b>{{$prioridade->tempo_atendimento}}</span>
                                    <span class="c-lista_drag-item-span-20 text-center" data-toggle="tooltip"
                                          title="Tempo de Resolução"><b>T.R: </b>{{$prioridade->tempo_resolucao}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <script type="text/javascript">
                function ocultarPopover() {
                    $('#sortable1').popover('hide');
                }

                @if($agent->isMobile())
                function salvar() {
                    var prioridades = '';

                    $('.lista-enviar li').each(function (index, obj) {
                        $check = $($(obj).find('input'));
                        if ($check.prop('checked')) {
                            prioridades = prioridades + $(obj).attr('data-id') + '|';
                        }
                    });
                    if (prioridades !== '') {
                        $('#prioridades').val(prioridades);
                        $('#enviar').click();
                    }else{
                        var html = '<div class="alert alert-danger">\n' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span\n' +
                            'aria-hidden="true">&times;</span></button>\n' +
                            '<strong>Você deve selecionar pelo menos uma prioridade!</strong>\n' +
                            '</div>';
                        $('.alertas').html(html);
                    }
                }
                @else
                function salvar() {
                    var prioridades = '';
                    if ($('.lista-enviar li').length > 0) {
                        $('.lista-enviar li').each(function (index, obj) {
                            prioridades = prioridades + $(obj).attr('data-id') + '|';
                        });
                        $('#prioridades').val(prioridades);
                        $('#enviar').click();
                    }
                    else {
                        var html = '<div class="alert alert-danger">\n' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span\n' +
                            'aria-hidden="true">&times;</span></button>\n' +
                            '<strong>Você deve selecionar pelo menos uma prioridade!</strong>\n' +
                            '</div>';
                        $('.alertas').html(html);
                    }
                }
                @endif
            </script>
            <a class="btn btn-success" onclick="salvar()">Cadastrar</a>
            <input id="prioridades" name="prioridades" type="hidden" value="">
            <input id="enviar" type="submit" class="hidden">
        </div>
    </form>
@stop