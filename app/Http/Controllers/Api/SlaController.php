<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SlaCollection;
use App\Http\Resources\SlaResource;
use App\PrioridadesSla;
use App\Empresa;
use App\Sla;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SlaController extends Controller
{
    public function index()
    {
        return new SlaCollection(Sla::all());
    }

    public function store(Request $request)
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

        return new SlaResource($sla);
    }

    public function show(Sla $sla)
    {
        return new SlaResource($sla);
    }

    public function update(Request $request, Sla $sla)
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
        return new SlaResource($sla);
    }

    public function destroy($id)
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
            return 'Excluido com sucesso!';
        }
    }
}
