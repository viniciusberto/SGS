<?php

namespace App\Http\Controllers;

use App\Sla;
use App\Prioridade;
use App\PrioridadesSla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrioridadeController extends Controller
{
    public function index($orderBy = null, $order = null)
    {
        if (isset($order) && isset($orderBy)) {
            $prioridades = DB::table('prioridades')->select('*')->orderBy($orderBy, $order)->get()->toArray();
        } else {
            $prioridades = Prioridade::all();
        }

        $temp = [];
        foreach ($prioridades as $prioridade) {
            $prioridadesSla = PrioridadesSla::where('prioridade_id', $prioridade->id)->get();
            $slas = [];
            foreach ($prioridadesSla as $item):
                $slas[] = $item->sla_id;
            endforeach;
            $slas = Sla::whereIn('id', $slas)->get()->toArray();

            foreach ($slas as $key => $sla) {
                unset($sla['created_at']);
                unset($sla['updated_at']);
                $slas[$key] = $sla;
            }

            $tempp['id'] = $prioridade->id;
            $tempp['descricao'] = $prioridade->descricao;
            $tempp['tempo_atendimento'] = $prioridade->tempo_atendimento;
            $tempp['tempo_resolucao'] = $prioridade->tempo_resolucao;


            $modal = array(
                'title' => 'Detalhes da Prioridade ' . $prioridade->descricao,
                'data' => [
                    [
                        'title' => 'SLA\'s com esta prioridade',
                        'thead' => ['id', 'Nome'],
                        'tbody' => $slas,
                        'route' => 'sla'
                    ]],
                'buttons' => ['back' => 'Fechar', 'exclude' => 'Excluir']
            );
            $tempp['modal'] = $modal;
            $temp[] = $tempp;
        }

        $table = array(
            'thead' => ['#', 'descricao' => 'Descrição', 'Tempo de Atendimento', 'Tempo de Resolução'],
            'tbody' => $temp,
            'actions' => [
                'edit' => 'Editar',
                'trash' => 'Excluir'
            ],
            'tfoot' => ['#', 'descricao' => 'Descrição', 'Tempo de Atendimento', 'Tempo de Resolução'],
        );


        return view('listar', [
            'title' => 'Prioridades',
            'action' => 'Adicionar Nova',
            'route' => 'prioridade',
            'order' => [
                'orderby' => $orderBy,
                'order' => $order
            ],
            'table' => $table,
        ]);


    }

    public function create()
    {
        return view('prioridade.cadastrar');
    }

    public function store(Request $request)
    {
        $descricao = $request->input('descricao');
        $tempo_atendimento = intval($request->input('tempo_atendimento'));
        $tempo_resolucao = intval($request->input('tempo_resolucao'));

        $prioridade = new Prioridade();
        $prioridade->setAttribute('descricao', $descricao);
        $prioridade->setAttribute('tempo_atendimento', $tempo_atendimento);
        $prioridade->setAttribute('tempo_resolucao', $tempo_resolucao);
        $prioridade->save();

        return redirect()->route('prioridade.index')->with('status', 'Cadastrado com sucesso!');
    }

    public function edit(Prioridade $prioridade)
    {
        return view('prioridade.editar', ['prioridade' => $prioridade]);
    }

    public function update(Request $request, Prioridade $prioridade)
    {
        $descricao = $request->input('descricao');
        $tempo_atendimento = intval($request->input('tempo_atendimento'));
        $tempo_resolucao = intval($request->input('tempo_resolucao'));

        $prioridade->setAttribute('descricao', $descricao);
        $prioridade->setAttribute('tempo_atendimento', $tempo_atendimento);
        $prioridade->setAttribute('tempo_resolucao', $tempo_resolucao);
        $prioridade->save();

        return redirect()->route('prioridade.index')->with('status', 'Atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $slasAtuais = PrioridadesSla::where('prioridade_id', $id)->get();
        if ($slasAtuais->count() > 0) {
            return redirect()->route('prioridade.index')->with('status', 'A prioridade não foi removida pois exitem SLA\'s vinculadas a ela!');
        } else {
            $prioridade = Prioridade::find($id);
            $prioridade->delete();
            return redirect()->route('prioridade.index')->with('status', 'A Prioridade foi removida!');
        }

    }
}
