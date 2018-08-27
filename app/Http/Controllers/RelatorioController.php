<?php

namespace App\Http\Controllers;

use App\Dispositivo;
use App\Empresa;
use App\Prioridade;
use App\Problema;
use App\Sla;
use App\Solucao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Chamado;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{
    public function novo()
    {
        $empresas = Empresa::all();
        if (Auth::user()->tipo == User::TIPO_SOLICITANTE) {
            $empresas = $empresas->where('id', Auth::user()->empresa_id);
        }

        return view('relatorio.novo', array(
            'empresas' => $empresas
        ));
    }

    public function gerar(Request $request)
    {
        $empresa_id = $request->input('empresa');
        $inicio = $request->input('inicio');
        $inicio .= ' 00:00:00';
        $fim = $request->input('fim');
        $fim .= ' 23:59:59';

        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Campo_Grande');
        if (date('M', strtotime($inicio)) != date('M', strtotime($fim))) {
            $periodo = ' DE ' . strftime('%b/%Y', strtotime($inicio)) . ' À ' . strftime('%b/%Y', strtotime($fim));
        } else {
            $periodo = strtoupper(' DE ' . strftime('%d/%b', strtotime($inicio)) . ' À ' . strftime('%d/%b', strtotime($fim)) . ' de ' . strftime('%Y', strtotime($fim)));
        }

        $empresa = Empresa::find($empresa_id);
        $sla = Sla::find($empresa->sla_id);
        $usuarios = User::where('empresa_id', $empresa_id)->get();
        $usuarios_id = [];

        foreach ($usuarios as $usuario) {
            $usuarios_id[] = $usuario->id;
        }

        $chamados = Chamado::whereIn('solicitante_id', $usuarios_id);
        $chamados = $chamados->where('status', Chamado::STATUS_FECHADO);
        $chamados = $chamados->whereBetween('data_abertura', [$inicio, $fim])->get();
        $prioridadesObj = DB::table('prioridades')
            ->join('prioridades_slas', 'prioridades_slas.prioridade_id', '=', 'prioridades.id')
            ->join('slas', 'prioridades_slas.sla_id', '=', 'slas.id')
            ->where('prioridades_slas.sla_id', $sla->id)
            ->select('prioridades.*')
            ->get();
        $prioridades = [];

        if (count($chamados) > 0) {

            foreach ($prioridadesObj as $prioridade) {
                $tempoTotalPrioridade = $prioridade->tempo_atendimento + $prioridade->tempo_resolucao;
                $chamadosPrioridade = $chamados->where('prioridade_id', $prioridade->id);

                $dentro = 0;
                foreach ($chamadosPrioridade as $cp) {
                    $tempo = strtotime($cp->data_fechamento) - strtotime($cp->data_abertura);
                    $tempo = intval($tempo / 60);
                    if ($tempoTotalPrioridade - $tempo >= 0) {
                        $dentro++;
                    }
                }
                $prioridades[$prioridade->descricao] = [
                    'tempo' => $tempoTotalPrioridade,
                    'chamados_total' => $chamadosPrioridade->count(),
                    'n_chamados_no_tempo' => $dentro,
                    'n_chamados_fora_tempo' => $chamadosPrioridade->count() - $dentro,
                    'p_chamados_no_tempo' => intval(($dentro * 100) / $chamados->count()),
                    'p_chamados_fora_tempo' => intval((($chamadosPrioridade->count() - $dentro) * 100) / $chamados->count()),
                ];
            }
            $dentro = 0;
            foreach ($prioridades as $prioridade) {
                $dentro += $prioridade['n_chamados_no_tempo'];
            }


            $pFora = intval((($chamados->count() - $dentro) * 100) / $chamados->count());
            $pDentro = intval(($dentro * 100) / $chamados->count());
            $chamadoExibicao = [];
            foreach ($chamados as $chamado) {
                $problema = Problema::find($chamado->problema_id);
                $chamado->setAttribute('empresa', $empresa->nome);
                $chamado->setAttribute('solicitante', User::find($chamado->solicitante_id)->name);
                $chamado->setAttribute('data', date('d/m/Y', strtotime($chamado->data_abertura)));
                $chamado->setAttribute('tecnico', User::find($chamado->tecnico_id)->name);
//            $chamado->setAttribute('tipoAtendimento',$empresa->nome);
                $chamado->setAttribute('equipamento', Dispositivo::find($chamado->equipamento_id)->descricao);
                $chamado->setAttribute('problema', $problema->descricao);
                $chamado->setAttribute('solucao', Solucao::find($problema->solucao_id)->descricao);
                $chamado->setAttribute('status', Chamado::verificarStatus($chamado->status));
                $chamadoExibicao[] = $chamado;
            }
            $relatorio = [
                'prioridades' => $prioridades,
                'chamados' => $chamados,
                'n_chamados_nao_atedeu_sla' => $chamados->count() - $dentro,
                'n_chamados_atendeu_sla' => $dentro,
                'p_chamados_nao_atendeu_sla' => $pFora,
                'p_chamados_atendeu_sla' => $pDentro,
                'periodo' => $periodo,

            ];
            return view('relatorio.preview', array('relatorio' => $relatorio));
        } else {
            return view('relatorio.preview')->with('status', 'Nenhum chamado realizado neste período!');
        }
    }
}
