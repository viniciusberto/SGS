<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Sla;
use App\Prioridade;
use App\PrioridadesSla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlaController extends Controller
{
    public function index($orderby = null, $order = null)
    {
        if (isset($order) && isset($orderby)) {
            $slas = DB::table('slas')
                ->select('slas.id', 'slas.nome')->orderBy($orderby, $order)->get()->toArray();
        } else {
            $slas = DB::table('slas')
                ->select('slas.id', 'slas.nome')->get()->toArray();
        }

        foreach ($slas as $key => $sla) {
            $prioridades = DB::table('prioridades')
                ->join('prioridades_slas', 'prioridades.id', '=', 'prioridades_slas.prioridade_id')
                ->join('slas', 'slas.id', '=', 'prioridades_slas.sla_id')
                ->where([
                    ['prioridades_slas.sla_id', '=', $sla->id]
                ])
                ->select('prioridades.id', 'prioridades.descricao as name', 'prioridades.tempo_atendimento', 'prioridades.tempo_resolucao')->get()->toArray();
            foreach ($prioridades as $chave => $prioridade) {
                $prioridades[$chave] = (Array)$prioridade;
            }

//            echo '<pre>';
//            var_dump($prioridades);
//            exit;

            $modal = array(
                'title' => 'Detalhes da SLA ' . $sla->nome,
                'data' => [
                    [
                        'title' => 'Prioridades',
                        'thead' => ['id', 'Descricao', 'Tempo Atendimento', 'Tempo Solução'],
                        'tbody' => $prioridades,
                        'route' => 'prioridade'
                    ]],
                'buttons' => ['back' => 'Voltar', 'exclude' => 'Excluir']
            );
            $sla = (Array)$sla;
            $sla['modal'] = $modal;
            $slas[$key] = $sla;
        }

        $table = array(
            'thead' => ['#', 'nome' => 'Nome'],
            'tbody' => $slas,
            'actions' => ['edit' => 'Editar'],
            'tfoot' => ['#', 'nome' => 'Nome'],
        );


        return view('listar', [
            'title' => 'SLA\'s',
            'action' => 'Adicionar Nova',
            'route' => 'sla',
            'table' => $table,
            'order' => [
                'orderby' => $orderby,
                'order' => $order
            ]
        ]);


//        $slas = Sla::all();
//
//        foreach ($slas as $sla):
//            $prioridadesSla = PrioridadesSla::all();
//            $prioridadesSla = $prioridadesSla->where('sla_id', $sla->id);
//            $prioridades = [];
//
//            foreach ($prioridadesSla as $item):
//                $prioridades[] = $item->prioridade_id;
//            endforeach;
//
//            $prioridades = Prioridade::whereIn('id', $prioridades)->get();
//            $sla->setAttribute('prioridades', $prioridades);
//
//            $empresas = Empresa::where('sla_id', $sla->id)->get();
//            $sla->setAttribute('empresas', $empresas);
//        endforeach;
//
//        return view('sla.listar', array('slas' => $slas));
        }

        public
        function create()
        {
            $prioridades = Prioridade::all();
            return view('sla.cadastrar', array('prioridades' => $prioridades));
        }

        public
        function store(Request $request)
        {
            $nome = $request->input('nome');
            $sla = new Sla();
            $sla->setAttribute('nome', $nome);
            $sla->save();
            $lista = $request->input('prioridades');
            $aux = '';
            foreach (str_split($lista) as $char):
                if ($char != '|') {
                    $aux = $aux . $char;
                } else {
                    $prioridadesSla = new PrioridadesSla();
                    $prioridadesSla->setAttribute('sla_id', $sla->id);
                    $prioridadesSla->setAttribute('prioridade_id', intval($aux));
                    $prioridadesSla->save();
                    $aux = '';
                }
            endforeach;

            return redirect()->route('sla.index')->with('status', 'SLA Salva com sucesso!');
        }

        public
        function edit($id)
        {
            $sla = Sla::find(intval($id));
            $prioridadesAtuais = PrioridadesSla::where('sla_id', intval($id))->get();
            $arrayAtual = [];
            foreach ($prioridadesAtuais as $prioridadeA):
                $arrayAtual[] = $prioridadeA->prioridade_id;
            endforeach;
            $prioridades = Prioridade::whereNotIn('id', $arrayAtual)->get();
            $prioridadesAtuais = Prioridade::whereIn('id', $arrayAtual)->get();

            return view('sla.editar', [
                'prioridadesAtuais' => $prioridadesAtuais,
                'prioridades' => $prioridades,
                'sla' => $sla,
            ]);
        }

        public
        function update(Request $request, Sla $sla)
        {
            $nome = $request->input('nome');
            $sla->setAttribute('nome', $nome);
            $prioridades = $request->input('prioridades');

            $prioridadesAtuais = PrioridadesSla::where('sla_id', $sla->id)->get();
            foreach ($prioridadesAtuais as $prioridadeA):
                $prioridadeA->delete();
            endforeach;

            $aux = '';
            foreach (str_split($prioridades) as $char):
                if ($char != '|') {
                    $aux = $aux . $char;
                } else {
                    $prioridadesSla = new PrioridadesSla();
                    $prioridadesSla->setAttribute('sla_id', $sla->id);
                    $prioridadesSla->setAttribute('prioridade_id', intval($aux));
                    $prioridadesSla->save();
                    $aux = '';
                }
            endforeach;
            $sla->save();
            return redirect()->route('sla.index')->with('status', 'Atualizada com sucesso!');
        }

        public
        function destroy($id)
        {
            $empresas = Empresa::where('sla_id', $id)->get();
            if ($empresas->count() > 0) {
                return redirect()->route('sla.index')->with('status', 'A SLA não foi removida pois exitem empresas vinculadas a ela!');
            } else {
                $prioridadesAtuais = PrioridadesSla::where('sla_id', $id)->get();
                foreach ($prioridadesAtuais as $prioridadeA):
                    $prioridadeA->delete();
                endforeach;

                $sla = Sla::find($id);
                $sla->delete();
                return redirect()->route('sla.index')->with('status', 'A SLA foi removida!');
            }
        }
    }
