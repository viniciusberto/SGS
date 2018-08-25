<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PrioridadeCollection;
use App\Http\Resources\PrioridadeResource;
use App\Prioridade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Stmt\Return_;

class PrioridadeController extends Controller
{

    public function index()
    {
        return new PrioridadeCollection(Prioridade::all());
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

        return new PrioridadeResource($prioridade);
    }

    public function show(Prioridade $prioridade)
    {
        return new PrioridadeResource($prioridade);
    }

    public function update(Request $request, Prioridade $prioridade)
    {
        $descricao = $request->input('descricao');
        $tempo_atendimento = intval($request->input('tempo_atendimento'));
        $tempo_resolucao = intval($request->input('tempo_resolucao'));


        if($descricao)
        $prioridade->setAttribute('descricao',$descricao);
        if($tempo_atendimento)
        $prioridade->setAttribute('tempo_atendimento',$tempo_atendimento);
        if($tempo_resolucao)
        $prioridade->setAttribute('tempo_resolucao',$tempo_resolucao);

        $prioridade->save();

        return new PrioridadeResource($prioridade);
    }

    public function destroy($id)
    {
        $prioridade = Prioridade::find($id);
        $prioridade->delete();

        return 'Removido com sucesso!';
    }
}
