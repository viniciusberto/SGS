<?php

namespace App\Http\Controllers;

use App\Sla;
use App\Prioridade;
use App\PrioridadesSla;
use Illuminate\Http\Request;

class PrioridadeController extends Controller
{
    public function index()
    {
        $prioridades = Prioridade::all();
        foreach ($prioridades as $prioridade) {
            $prioridadesSla = PrioridadesSla::where('prioridade_id', $prioridade->id)->get();
            $slas = [];
            foreach ($prioridadesSla as $item):
                $slas[] = $item->sla_id;
            endforeach;

            $slas = Sla::whereIn('id', $slas)->get();
            $prioridade->setAttribute('slas', $slas);

        }
        return view('prioridade.listar', [
            'prioridades' => $prioridades,
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
        $prioridade->setAttribute('descricao',$descricao);
        $prioridade->setAttribute('tempo_atendimento',$tempo_atendimento);
        $prioridade->setAttribute('tempo_resolucao',$tempo_resolucao);
        $prioridade->save();

        return redirect()->route('prioridade.index')->with('status','Cadastrado com sucesso!');
    }

    public function edit(Prioridade $prioridade)
    {
        return view('prioridade.editar',['prioridade' => $prioridade]);
    }

    public function update(Request $request, Prioridade $prioridade)
    {
        $descricao = $request->input('descricao');
        $tempo_atendimento = intval($request->input('tempo_atendimento'));
        $tempo_resolucao = intval($request->input('tempo_resolucao'));

        $prioridade->setAttribute('descricao',$descricao);
        $prioridade->setAttribute('tempo_atendimento',$tempo_atendimento);
        $prioridade->setAttribute('tempo_resolucao',$tempo_resolucao);
        $prioridade->save();

        return redirect()->route('prioridade.index')->with('status','Atualizado com sucesso!');
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
