<?php

namespace App\Http\Controllers;

use App\Chamado;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->tipo == User::TIPO_ADMIN) {
            $analise = Chamado::where('status', Chamado::STATUS_ANALISE)->get()->count();
            $abertos = Chamado::where('status', Chamado::STATUS_ABERTO)->get()->count();
            $aceitacao = Chamado::where('status', Chamado::STATUS_ANALISE_ACEITACAO)->get()->count();
            $aceitos = Chamado::where('status', Chamado::STATUS_ACEITO)->get()->count();
            $atendimentos = Chamado::where('status', Chamado::STATUS_ATENDIMENTO)->get()->count();
            $fechamentos = Chamado::where('status', Chamado::STATUS_ANALISE_FECHAMENTO)->get()->count();
            $fechados = Chamado::where('status', Chamado::STATUS_FECHADO)->get()->count();
            return view('dashboard.administrador', [
                'analise' => $analise,
                'abertos' => $abertos,
                'aceitacao' => $aceitacao,
                'aceitos' => $aceitos,
                'atendimentos' => $atendimentos,
                'fechamentos' => $fechamentos,
                'fechados' => $fechados
            ]);
        }
        if (Auth::user()->tipo == User::TIPO_TECNICO) {
            $analise = Chamado::where('status', Chamado::STATUS_ANALISE)->get()->count();
            $abertos = Chamado::where('status', Chamado::STATUS_ABERTO)->get()->count();

            $chamados = Chamado::where('tecnico_id',Auth::user()->id)->get();
            $aceitacao = $chamados->where('status', Chamado::STATUS_ANALISE_ACEITACAO)->count();
            $aceitos = $chamados->where('status', Chamado::STATUS_ACEITO)->count();
            $atendimentos = $chamados->where('status', Chamado::STATUS_ATENDIMENTO)->count();
            $fechamentos = $chamados->where('status', Chamado::STATUS_ANALISE_FECHAMENTO)->count();
            $fechados = $chamados->where('status', Chamado::STATUS_FECHADO)->count();
            return view('dashboard.tecnico', [
                'analise' => $analise,
                'abertos' => $abertos,
                'aceitacao' => $aceitacao,
                'aceitos' => $aceitos,
                'atendimentos' => $atendimentos,
                'fechamentos' => $fechamentos,
                'fechados' => $fechados
            ]);
        }
        if (Auth::user()->tipo == User::TIPO_SOLICITANTE) {
            $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->get();
            $usuarios_id = [];
            foreach ($usuarios as $usuario) {
                $usuarios_id[] = $usuario->id;
            }

            $chamados = Chamado::whereIn('solicitante_id', $usuarios_id)->get();
            $abertos = [Chamado::STATUS_ANALISE, Chamado::STATUS_ABERTO, Chamado::STATUS_ANALISE_ACEITACAO, Chamado::STATUS_ACEITO];
            $abertos = $chamados->whereIn('status', $abertos)->count();

            $atendimentos = [Chamado::STATUS_ATENDIMENTO, Chamado::STATUS_ANALISE_FECHAMENTO];
            $atendimentos = $chamados->whereIn('status', $atendimentos)->count();

            $fechados = $chamados->where('status', Chamado::STATUS_FECHADO)->count();


            return view('dashboard.solicitante', [
                'abertos' => $abertos,
                'atendimentos' => $atendimentos,
                'fechados' => $fechados
            ]);
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
