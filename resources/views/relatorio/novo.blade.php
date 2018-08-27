@extends('layouts.layout')
@section('title')
    Gerar Relatório
@stop
@section('content')
    <form class="container-fluid sem-padding" method="POST" action="{{route('relatorio.gerar')}}">
        {{csrf_field()}}
        <div class="form-group row">
            <div class="col-md-12">
                <label for="empresa">Empresa</label>
                <select name="empresa" id="empresa" class="form-control" required>
                    <option value="">Selecione uma empresa</option>
                    @foreach($empresas as $empresa)
                        <option value="{{$empresa->id}}">{{$empresa->nome}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group container-fluid sem-padding row" id="periodo">

            <div class="col-md-3">
                <label for="inicio">Ínicio</label>
                <input class="form-control" type="date" name="inicio" id="inicio" required>
            </div>

            <div class="col-md-3">
                <label for="inicio">Fim</label>
                <input class="form-control" type="date" name="fim" id="fim" required>
            </div>
        </div>

        <button class="btn btn-success">Gerar</button>
    </form>
@stop