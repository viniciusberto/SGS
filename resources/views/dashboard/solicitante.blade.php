@extends('layouts.layout')

@section('title')
    Painel de Controle
@stop
@php
    use App\Chamado;
@endphp

@section('content')
    <div class="col-lg-3 col-md-4">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="icone fa fa-compress"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div id="abertos" class="huge">{{$abertos}}</div>
                    </div>
                </div>
            </div>
            <a href="{{route('chamado.listar',['status' => Chamado::STATUS_ABERTO])}}">
                <div class="panel-footer">
                    <span class="pull-left">Abertos</span>
                    <span class="pull-right"><i
                                class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="icone fa fa-car"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div id="atendimentos" class="huge">{{$atendimentos}}</div>
                    </div>
                </div>
            </div>
            <a href="{{route('chamado.listar',['status' => Chamado::STATUS_ATENDIMENTO])}}">
                <div class="panel-footer">
                    <span class="pull-left">Em Atendimento</span>
                    <span class="pull-right"><i
                                class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="panel panel-verde">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="icone fa fa-check"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div id="fechados" class="huge">{{$fechados}}</div>
                    </div>
                </div>
            </div>
            <a href="{{route('chamado.listar',['status' => Chamado::STATUS_FECHADO])}}">
                <div class="panel-footer">
                    <span class="pull-left">Finalizados</span>
                    <span class="pull-right"><i
                                class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>


@stop