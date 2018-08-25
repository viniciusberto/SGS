<?php

namespace App\Http\Controllers;

use App\Dispositivo;
use App\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispositivoController extends Controller
{
    public function index()
    {
        $dispositivos = Dispositivo::all()->sortBy('empresa_id');
        $dispositivos->each(function ($item, $index){
            $item->setAttribute('empresa', Empresa::find($item->empresa_id)->nome);
        });

        return view('dispositivo.listar', ['dispositivos' => $dispositivos]);
    }

    public function create()
    {
        $empresas = Empresa::all();
        return view('dispositivo.cadastrar',['empresas' => $empresas]);
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
