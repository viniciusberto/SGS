@extends('layouts.layout')
@section('title')
    Visualisar Relatório
@stop
@section('content')
    <style>
        canvas {
            /*background:#f3f3f3;*/
            overflow: scroll !important;
            transform: translate3d(0, 0, 0);
            width: 45%;
            float: left;
        }

        #grafico_barras {
            width: 100%;
            float: none;
            max-height: 243px;
        }

        @media print {
            #grafico_barras {
                max-height: 154px !important;
            }

            .indicador {
                font-size: 10px !important;
            }

            .quebrar-pagina {
                page-break-before: always;
            }

            .table {
                width: 100%;
                text-align: left;

            }

            .table thead {
                background: #A8CF45;
                color: white;
                border-top: 2px solid black;
            }

            table.table {
                border-collapse: collapse;
            }

            table.table tr td {
                border: 2px solid #000;
            }

            table.table tr th {
                border: 2px solid #000;
            }

            .indicador {
                display: block !important;
                margin: 0 !important;
                margin-top: 10px !important;
                line-height: 12px !important;
            }

            /*.indicadores .indicador:first-child {*/
            /*margin-top: 10px!important;*/
            /*}*/
            /*.indicador:first-line {*/
            /*line-height: 15px;*/
            /*}*/
            .indicador::before {
                line-height: 20px !important;
                background: #A8CF45 !important;
            }

            .negativo::before {
                line-height: 20px !important;
                background: red !important;
            }

            .neutro::before {
                background: #0d6aad !important;
                color: white !important;
                font-weight: bold !important;
            }

            .page-header {
                display: none;
            }
        }

        .cabecalho {
            height: 50px;
            padding-bottom: 5px;
            border-bottom: 2px solid black;
        }

        .cabecalho img {
	    height: 55px;
	    float: left;
    	    padding-bottom: 12px;
        }

        .cabecalho span {
            margin-left: -150px;
            line-height: 50px;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;

        }

        .descricao {
            margin-top: 20px;
        }

        .clear {
            clear: both;
        }

        .graficos {
            margin: 0 auto;
            width: 100%;
            display: block;
            overflow: hidden;
        }

        .grafico {

            float: left;
            margin-top: 20px;
            padding: 10px;
            /*margin-bottom: 100px;*/
            width: 50%;
            display: inline-block;
            box-sizing: border-box;
            margin-left: 50%;
            transform: translateX(-50%);
        }

        .titulo-grafico {
            font-size: 15px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .indicadores {
            margin-left: 60%;
        }

        /*.indicador:first-line {*/
        /*line-height: 20px;*/
        /*}*/

        .indicador {
            display: block;
            margin: 0;
            margin-top: 5px;
            font-size: 13px;
            line-height: 20px;
        }

        .indicadores .indicador:first-child {
            margin-top: 10px;
        }

        .indicador::before {
            content: attr(porcentagem);
            text-align: center;
            line-height: 20px;
            font-size: 9px;
            position: absolute;
            width: 25px;
            height: 20px;
            background-color: #A8CF45;
            margin-left: -30px;
        }

        .negativo::before {
            background: red;
            content: attr(porcentagem);
        }

        .neutro::before {
            background: #0d6aad;
            color: white;
            font-weight: bold;
        }

        .relatorio {
            /*margin-top: 30px;*/
        }

        .titulo-relatorio {
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            text-align: left;
        }

        .table thead {
            background: #A8CF45;
            color: white;
            border-top: 2px solid black;
        }

        table.table {
            border-collapse: collapse;
        }

        table.table tr td {
            border: 2px solid #000;
        }

        table.table tr th {
            border: 2px solid #000;
        }

        .titulo-resumo-grafico {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .container {
            margin: 0 auto;
            max-width: 1140px;
        }

        .text-center {
            text-align: center;
        }

        .grafico-direita {
            border-left: none;
        }
    </style>



















    <div class="container-relatorios">
        <div class="cabecalho text-center">
            <img src="/imagens/logo-relatorio.png" alt="">
            <span>HávilaInfo Consultoria em TI</span>
        </div>
        <div class="descricao">
            <div class="text-center"><h1 class="titulo-resumo-grafico">RESUMO GRÁFICO DE SERVIÇOS
                    PRESTADOS{{$relatorio['periodo']}}</h1></div>
        </div>


        <div class="graficos">
            <div class="grafico">
                <div class="titulo-grafico text-center">
                    Atendimentos
                </div>
                <canvas id="grafico_pizza"></canvas>
                <div class="indicadores">
                    <div porcentagem="{{$relatorio['p_chamados_atendeu_sla']}}%" class="indicador">Finalizados dentro do
                        Tempo
                    </div>
                    <div porcentagem="{{$relatorio['p_chamados_nao_atendeu_sla']}}%" class="indicador negativo">Não
                        cumpriu a SLA
                    </div>
                    <div porcentagem="{{$relatorio['chamados']->count()}}" class="indicador neutro">número de chamados
                        realizados
                        neste período.
                    </div>
                </div>
            </div>
            {{--<div class="grafico grafico-direita">--}}
            {{--<div class="titulo-grafico text-center">--}}
            {{--Atendimentos--}}
            {{--</div>--}}
            {{--<canvas id="grafico_barras"></canvas>--}}
            {{--<div class="indicadores">--}}
            {{--<div class="indicador">Finalizados dentro da SLA</div>--}}
            {{--<div class="indicador">Não cumpriu a SLA</div>--}}
            {{--</div>--}}
            {{--</div>--}}
        </div>


        <div class="relatorio clear">
            <div class="titulo-relatorio text-center"><b><h1 class="titulo-resumo-grafico">RELATÓRIO DE SERVIÇOS
                        PRESTADOS{{$relatorio['periodo']}}</h1></b></div>
            @php
                $contador = 0;
            @endphp
            @foreach($relatorio['chamados'] as $chamado)

                <table class="table">
                    <thead>
                    <tr>
                        <th><b>OS:</b>
                            @if($chamado->id < 1000 && $chamado->id >= 100)
                                0{{$chamado->id}}
                            @endif
                            @if($chamado->id < 100 && $chamado->id >= 10)
                                00{{$chamado->id}}
                            @endif
                            @if($chamado->id < 10)
                                000{{$chamado->id}}
                            @endif
                        </th>
                        <th><b>Data: </b>{{$chamado->data}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="2"><b>Empresa: {{$chamado->empresa}}</b></td>
                    </tr>
                    <tr>
                        <td><b>Solicitado por: {{$chamado->solicitante}}</b></td>
                        <td><b>Atendido por: {{$chamado->tecnico}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Tipo de Atendimento: {{$chamado->tipo_atendimento}}</b></td>
                    </tr>
                    <tr>
                        <td><b>Patrimônio: Não cadastrado</b></td>
                        <td><b>Equipamento: {{$chamado->equipamento}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Problema: {{$chamado->problema}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Descrição do serviço: {{$chamado->solucao}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Status: {{$chamado->status}}</b></td>
                    </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
                @if($contador == 0 or $contador%3 == 0)
                    <div class="quebrar-pagina"></div>
                @endif
                @php
                    $contador++;
                @endphp
            @endforeach


        </div>


    </div>





















    <script>
        //Configuracoes
        var dashboard = document.getElementById('grafico_pizza');
        var docHeight = 400;// document.documentElement.clientHeight - 20; // - 20 jsFiddle hack
        var docWidth = 400;//document.documentElement.clientWidth - 20;
        dashboard.height = docHeight;
        dashboard.width = docWidth;
        var ctx;
        // objeto para ser preenchido do tipo Grafico de Pie(Pizza)
        var grafico = {
            espessura: 20,
            corLinha: 'white',
            cores: ['red', '#A8CF45'],//,'red','gray','orange','violet','black','orange','darkgreen','purple'],
            gap: 1,
            dataProvider: [],
            init: function () {
                var total = 0;
                var anguloAntigo = 11;
                for (var i = 0; i < this.dataProvider.length; i++) {
                    total += this.dataProvider[i];
                }
                ctx = dashboard.getContext('2d');

                for (var i = 0; i < this.dataProvider.length; i++) {
                    var proporcao = this.dataProvider[i] / total;
                    var fatia = 2 * Math.PI * proporcao;
                    ctx.beginPath();
                    var angulo = anguloAntigo + fatia;
                    ctx.fillStyle = this.cores[i];
                    ctx.arc(docWidth / 2, docHeight / 2, docWidth / 2, anguloAntigo, angulo);
                    ctx.lineTo(docWidth / 2, docHeight / 2);
                    ctx.lineWidth = this.gap;
                    ctx.strokeStyle = this.corLinha;
                    ctx.closePath();
                    ctx.fill();
                    ctx.stroke();
                    anguloAntigo += fatia;
                }
            }
        }

        function coresAleatorias() {
            return "#" + Math.random().toString(16).slice(2, 8);
        }


        grafico.dataProvider = [{{$relatorio['p_chamados_nao_atendeu_sla']}}, {{$relatorio['p_chamados_atendeu_sla']}}];
        grafico.columnHeight = 20; // seta largura da coluna
        grafico.init(); // inicializa<canvas width="100" height="100" id="grafico_area"></canvas>
    </script>

@stop
