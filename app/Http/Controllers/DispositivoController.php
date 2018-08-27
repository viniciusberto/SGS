<?php

namespace App\Http\Controllers;

use App\Dispositivo;
use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DispositivoController extends Controller
{
    public function index($orderBy = null, $order = null)
    {
        if (isset($order) && isset($orderBy)) {
            $dispositivos = DB::table('itens_configuracao')
                ->join('empresas', 'itens_configuracao.empresa_id', '=', 'empresas.id')
                ->select('itens_configuracao.id', 'itens_configuracao.descricao', 'empresas.nome')->orderBy($orderBy, $order)->get()->toArray();
        } else {
            $dispositivos = DB::table('itens_configuracao')
                ->join('empresas', 'itens_configuracao.empresa_id', '=', 'empresas.id')
                ->select('itens_configuracao.id', 'itens_configuracao.descricao', 'empresas.nome')->get()->toArray();
        }


        foreach ($dispositivos as $key => $dispositivo){
            $dispositivos[$key] = (Array)$dispositivo;
        }



        $table = array(
            'thead' => ['#', 'descricao' => 'Descrição', 'empresa_id' => 'Empresa'],
            'tbody' => $dispositivos,
            'actions' => [
                'edit' => 'Editar',
                'trash' => 'Excluir'
            ],
            'tfoot' => ['#', 'descricao' => 'Descrição', 'empresa_id' => 'Empresa'],
        );


        return view('listar', [
            'title' => 'Dispositivos',
            'action' => 'Adicionar Novo',
            'route' => 'dispositivo',
            'order' => [
                'orderby' => $orderBy,
                'order' => $order
            ],
            'table' => $table,
        ]);

    }

    public function create()
    {
        $empresas = Empresa::all();
        return view('dispositivo.cadastrar', ['empresas' => $empresas]);
    }

    public function store(Request $request)
    {
        $descricao = $request->input('descricao');
        $empresa_id = $request->input('empresa');

        if (!isset($empresa_id))
            $empresa_id = Auth::user()->empresa_id;

        $dispositivo = new Dispositivo();
        $dispositivo->setAttribute('descricao', $descricao);
        $dispositivo->setAttribute('empresa_id', $empresa_id);
        $dispositivo->save();

        return redirect()->route('dispositivo.index')->with('status', 'Dispositivo cadastrado com sucesso!');
    }

    public function edit(Dispositivo $dispositivo)
    {
        return view('dispositivo.editar', ['dispositivo' => $dispositivo]);
    }

    public function update(Request $request, Dispositivo $dispositivo)
    {
        $dispositivo->descricao = $request->input('descricao');
        $dispositivo->save();
        return redirect()->route('dispositivo.index')->with('status', 'Dispositivo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $dispositivo = Dispositivo::find($id);
        $dispositivo->delete();
        return redirect()->route('dispositivo.index')->with('status', 'Dispositivo removido com sucesso!');
    }
}
