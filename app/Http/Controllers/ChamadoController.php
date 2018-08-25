<?php

namespace App\Http\Controllers;

use function Acme\tester;
use App\Chamado;
use App\Dispositivo;
use App\Empresa;
use App\Prioridade;
use App\PrioridadesSla;
use App\Problema;
use App\Sla;
use App\Solucao;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChamadoController extends Controller
{
    public function index()
    {
        if (Auth::user()->tipo == User::TIPO_SOLICITANTE) {
            return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ABERTO]);
        } else {
            return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ANALISE]);
        }
    }

    public function listar($status)
    {
        $dispositivos = null;
        $prioridades = null;

        if (Auth::user()->tipo == User::TIPO_SOLICITANTE) {
            $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->get();
            $usuarios_id = [];
            foreach ($usuarios as $usuario) {
                $usuarios_id[] = $usuario->id;
            }
            $chamados = Chamado::whereIn('solicitante_id', $usuarios_id);

            if ($status == Chamado::STATUS_ANALISE || $status == Chamado::STATUS_ABERTO || $status == Chamado::STATUS_ANALISE_ACEITACAO || $status == Chamado::STATUS_ACEITO) {
                $abertos = [Chamado::STATUS_ANALISE, Chamado::STATUS_ABERTO, Chamado::STATUS_ANALISE_ACEITACAO, Chamado::STATUS_ACEITO];
                $chamados = $chamados->whereIn('status', $abertos)->get();
            } elseif ($status == Chamado::STATUS_ATENDIMENTO || $status == Chamado::STATUS_ANALISE_FECHAMENTO) {
                $atendimentos = [Chamado::STATUS_ATENDIMENTO, Chamado::STATUS_ANALISE_FECHAMENTO];
                $chamados = $chamados->whereIn('status', $atendimentos)->get();
            } elseif ($status == Chamado::STATUS_FECHADO) {
                $chamados = $chamados->where('status', Chamado::STATUS_FECHADO)->get();
            }
        } elseif(Auth::user()->tipo == User::TIPO_TECNICO){
            if ($status > Chamado::STATUS_ACEITO){
                $chamados = Chamado::where('status', $status)->orderBy('data_abertura', 'desc');
                $chamados = $chamados->where('tecnico_id',Auth::user()->id)->get();
            }else{
                $chamados = Chamado::where('status', $status)->orderBy('data_abertura', 'desc')->get();
            }
        } else {
            $chamados = Chamado::where('status', $status)->orderBy('data_abertura', 'desc')->get();
        }


        foreach ($chamados as $chamado):
            if ($status > Chamado::STATUS_ANALISE_ACEITACAO) {
                $tempo = strtotime($chamado->limite_resolucao) - strtotime(date('Y-m-d H:i:s'));
                if ($tempo > 0) {
                    date_default_timezone_set('UTC');
                    $tempo = date("H:i:s", $tempo);
                    date_default_timezone_set('America/Campo_Grande');
                } else {
                    $tempo = '00:00:00';
                }
                $limite_resolucao = date('d-m-Y H:i:s', strtotime($chamado->limite_resolucao));
                $chamado->limite_resolucao = $limite_resolucao;
            } else {
                $tempo = strtotime($chamado->limite_aceitacao) - strtotime(date('Y-m-d H:i:s'));
                if ($tempo > 0) {
                    date_default_timezone_set('UTC');
                    $tempo = date("H:i:s", $tempo);
                    date_default_timezone_set('America/Campo_Grande');
                } else {
                    $tempo = '00:00:00';
                }
            }
            if (isset($chamado->problema_id)) {
                $problema = $chamado->problema_id;

                $solucao = '';
                if (isset($problema)) {
                    $problema = Problema::find($problema);
                    $solucao = Solucao::find($problema->solucao_id);
                    $problema = $problema->descricao;
                    $solucao = $solucao->descricao;
                }
                $chamado->setAttribute('problema', $problema);
                $chamado->setAttribute('solucao', $solucao);
            }
            $data_abertura = date('d-m-Y H:i:s', strtotime($chamado->data_abertura));
            $equipamento = Dispositivo::find($chamado->equipamento_id)->descricao;
            $solicitante = User::find($chamado->solicitante_id);
            $empresa = Empresa::find($solicitante->empresa_id);
            $dispositivos = Dispositivo::where('empresa_id', $empresa->id)->get();
            $prioridadesSla = PrioridadesSla::where('sla_id', $empresa->sla_id)->get();
            $prioridades = [];
            foreach ($prioridadesSla as $pSla) {
                $prioridades[] = $pSla->prioridade_id;
            }
            $prioridades = Prioridade::whereIn('id', $prioridades)->get();
            $prioridade = Prioridade::find($chamado->prioridade_id);
            if (isset($chamado->tecnico_id))
                $tecnico = User::find($chamado->tecnico_id)->name;
            $sla = Sla::find($empresa->sla_id);
            $limite_aceitacao = date('d-m-Y H:i:s', strtotime($chamado->limite_aceitacao));
            $data_fechamento = date('d-m-Y H:i:s', strtotime($chamado->data_fechamento));

            $chamado->data_abertura = $data_abertura;
            $chamado->limite_aceitacao = $limite_aceitacao;
            $chamado->data_fechamento = $data_fechamento;

            $data_abertura = strtotime($chamado->data_abertura);
            $data_aceitacao = strtotime($chamado->data_aceitacao);
            $data_fechamento = strtotime($chamado->data_fechamento);
            $tempo_aceitacao = $data_aceitacao - $data_abertura;
            $tempo_fechamento = $data_fechamento - $data_aceitacao;

            date_default_timezone_set('UTC');
            $tempo_total = date('H:i:s', $tempo_aceitacao + $tempo_fechamento);
            $tempo_aceitacao = date('H:i:s', $tempo_aceitacao);
            $tempo_fechamento = date('H:i:s', $tempo_fechamento);
            date_default_timezone_set('America/Campo_Grande');


            $chamado->setAttribute('prioridade', $prioridade);
            $chamado->setAttribute('tempo', $tempo);
            $chamado->setAttribute('solicitante', $solicitante->name);
            $chamado->setAttribute('equipamento', $equipamento);
            $chamado->setAttribute('empresa', $empresa->nome);
            $chamado->setAttribute('sla', $sla);
            $chamado->setAttribute('tempo_aceitacao', $tempo_aceitacao);
            $chamado->setAttribute('tempo_fechamento', $tempo_fechamento);
            $chamado->setAttribute('tempo_total', $tempo_total);

            if (isset($tecnico))
                $chamado->setAttribute('tecnico', $tecnico);
        endforeach;
        switch ($status) {
            case Chamado::STATUS_ANALISE:
                return view('chamado.listagem.analize', [
                    'chamados' => $chamados,
                    'dispositivos' => $dispositivos,
                    'prioridades' => $prioridades,
                ]);
                break;
            case Chamado::STATUS_ABERTO:
                return view('chamado.listagem.abertos', [
                    'chamados' => $chamados,
                    'dispositivos' => $dispositivos,
                    'prioridades' => $prioridades,
                ]);
                break;
            case Chamado::STATUS_ANALISE_ACEITACAO:
                return view('chamado.listagem.analise_aceitacao', [
                    'chamados' => $chamados,
                    'dispositivos' => $dispositivos,
                    'prioridades' => $prioridades,
                ]);
                break;
            case Chamado::STATUS_ACEITO:
                return view('chamado.listagem.aceitos', [
                    'chamados' => $chamados,
                    'dispositivos' => $dispositivos,
                    'prioridades' => $prioridades,
                ]);
                break;
            case Chamado::STATUS_ATENDIMENTO:
                return view('chamado.listagem.atendimentos', [
                    'chamados' => $chamados,
                    'dispositivos' => $dispositivos,
                    'prioridades' => $prioridades,
                ]);
                break;
            case Chamado::STATUS_ANALISE_FECHAMENTO:
                return view('chamado.listagem.fechamentos', [
                    'chamados' => $chamados,
                    'dispositivos' => $dispositivos,
                    'prioridades' => $prioridades,
                ]);
                break;


            case Chamado::STATUS_FECHADO:
                return view('chamado.listagem.fechados', [
                    'chamados' => $chamados,
                    'dispositivos' => $dispositivos,
                    'prioridades' => $prioridades,
                ]);
                break;
        }

        return redirect()->route('dashboard.index');
    }

    public function create()
    {
        $solicitantes = User::all()->sortBy('empresa_id');
        $solicitantes->each(function ($item, $index) {
            $item->setAttribute('empresa', Empresa::find($item->empresa_id)->nome);
        });

        return view('chamado.cadastrar', ['solicitantes' => $solicitantes]);
    }

    public function store(Request $request)
    {
        $titulo = $request->input('titulo');
        $descricao = $request->input('descricao');
        $data_abertura = date('Y-m-d H:i:s');
        $status = Chamado::STATUS_ANALISE;
        $equipamento_id = Dispositivo::all()->first()->id;
        $solicitante = $request->input('solicitante');
        if (!isset($solicitante))
            $solicitante = Auth::user()->id;

        $solicitante = User::find($solicitante);
        $sla = Empresa::find($solicitante->empresa_id);
        $sla = PrioridadesSla::where('sla_id', $sla->sla_id)->get();
//        $sla = $sla;

//        echo '<pre>';
//        var_dump($sla);
//
//        exit();
        $prioridade = Prioridade::find(3);//$sla->prioridade_id);
        $tempo = $prioridade->tempo_atendimento;
        $tempo = $tempo * 60;

        $limite_aceitacao = date('Y-m-d H:i:s', strtotime($data_abertura) + $tempo);


        $chamado = new Chamado();
        $chamado->setAttribute('titulo', $titulo);
        $chamado->setAttribute('descricao', $descricao);
        $chamado->setAttribute('data_abertura', $data_abertura);
        $chamado->setAttribute('status', $status);
        $chamado->setAttribute('equipamento_id', $equipamento_id);
        $chamado->setAttribute('solicitante_id', intval($solicitante->id));
        $chamado->setAttribute('limite_aceitacao', $limite_aceitacao);
        $chamado->setAttribute('prioridade_id', $prioridade->id);
        $chamado->save();

        return redirect()->route('chamado.index')->with('status', 'Chamado aberto com sucesso!');
    }

    public function edit(Chamado $chamado)
    {
        //
    }

    public function update(Request $request, Chamado $chamado)
    {
        //
    }

    public function destroy(Chamado $chamado)
    {
        //
    }

    public function negarPedido(Request $request)
    {
        $id = $request->route('id');
        $chamado = Chamado::find($id);
        $tecnico = User::find($chamado->tecnico_id)->name;
        $chamado->setAttribute('tecnico_id', null);
        $chamado->setAttribute('status', Chamado::STATUS_ABERTO);
        $chamado->save();

        return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ABERTO])->with('status', "Você negou o pedido para o {$tecnico}!");
    }

    public function negarFechamento(Request $request)
    {
        $id = $request->route('id');
        $chamado = Chamado::find($id);

        $tecnico = User::find($chamado->tecnico_id)->name;
        $chamado->setAttribute('status', Chamado::STATUS_ATENDIMENTO);
        $chamado->save();

        return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ATENDIMENTO])->with('status', "Você negou o pedido de fechamento para o {$tecnico}!");
    }

    public function atualizar(Request $request)
    {
        $sts = $request->route('sts');
        $id = $request->route('id');
        $chamado = \App\Chamado::find($id);
        switch ($sts) {
            case Chamado::STATUS_ABERTO:
                $dispositivo = intval($request->input('dispositivo'));
                $prioridade = intval($request->input('prioridade'));
                $prioridade = Prioridade::find($prioridade);
                $tempo = $prioridade->tempo_atendimento;
                $tempo = $tempo * 60;
                $limite_aceitacao = date('Y-m-d H:i:s', strtotime($chamado->data_abertura) + $tempo);
                $chamado->setAttribute('equipamento_id', $dispositivo);
                $chamado->setAttribute('prioridade_id', $prioridade->id);
                $chamado->setAttribute('limite_aceitacao', $limite_aceitacao);
                $chamado->setAttribute('status', Chamado::STATUS_ABERTO);
                $chamado->save();
                return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ABERTO])->with('status', 'Classificado com sucesso!');
                break;
            case Chamado::STATUS_ANALISE_ACEITACAO:
                $tecnico_id = Auth::user()->id;
                $chamado->setAttribute('tecnico_id', $tecnico_id);
                $chamado->setAttribute('status', Chamado::STATUS_ANALISE_ACEITACAO);
                $chamado->save();
                return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ANALISE_ACEITACAO])->with('status', 'Está em analise de aceitação!');
                break;
            case Chamado::STATUS_ACEITO:
                $obs = $request->input('obs');
                if (isset($obs))
                    $chamado->setAttribute('obs', $obs);
                $chamado->data_aceitacao = date('Y-m-d H:i:s');
                $prioridade = Prioridade::find($chamado->prioridade_id);
                $tempo = $prioridade->tempo_resolucao;
                $tempo = $tempo * 60;
                $limite_resolucao = date('Y-m-d H:i:s', strtotime($chamado->data_aceitacao) + $tempo);
                $chamado->setAttribute('status', Chamado::STATUS_ACEITO);
                $chamado->setAttribute('limite_resolucao', $limite_resolucao);
                $chamado->save();
                return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ACEITO])->with('status', 'Confirmado com sucesso!');
                break;
            case Chamado::STATUS_ATENDIMENTO:
                $tipo = $request->input('tipo_atendimento');
                $chamado->setAttribute('status', Chamado::STATUS_ATENDIMENTO);
                $chamado->setAttribute('tipo_atendimento',$tipo);
                $chamado->save();
                return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ATENDIMENTO])->with('status', 'Pode sair para atender o cliente!');
                break;

            case Chamado::STATUS_ANALISE_FECHAMENTO:
                $des_problema = $request->input('problema');
                $des_solucao = $request->input('solucao');

                if (isset($des_problema)) {
                    $solucao = new Solucao();
                    $solucao->setAttribute('descricao', $des_solucao);
                    $solucao->save();

                    $problema = new Problema();
                    $problema->setAttribute('descricao', $des_problema);
                    $problema->setAttribute('solucao_id', $solucao->id);
                    $problema->save();

                    $chamado->setAttribute('problema_id', $problema->id);
                }

                $chamado->setAttribute('status', Chamado::STATUS_ANALISE_FECHAMENTO);
                $chamado->save();

                return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_ANALISE_FECHAMENTO])->with('status', 'O ADM irá analizar o fechamento!');
                break;

            case
            Chamado::STATUS_FECHADO:
                $chamado->setAttribute('status', Chamado::STATUS_FECHADO);
                $chamado->setAttribute('data_fechamento', date('Y-m-d H:i:s'));
                $chamado->save();

                return redirect()->route('chamado.listar', ['sts' => Chamado::STATUS_FECHADO])->with('status', 'Chamado fechado com sucesso!');
                break;
        }


    }


}
