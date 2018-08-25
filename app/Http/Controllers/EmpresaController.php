<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Sla;
use App\User;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::all();
        $empresas->each(function ($empresa, $index) {
            $funcionarios = User::where('empresa_id', $empresa->id)->get();
            $empresa->setAttribute('funcionarios', $funcionarios);
        });

        return view('empresa.listar', ['empresas' => $empresas]);
    }

    public function create()
    {
        $slas = Sla::all();
        return view('empresa.cadastrar', ['slas' => $slas]);
    }

    public function store(Request $request)
    {
        $nome = $request->input('nome');
        $sla_id = $request->input('sla_id');
        $cnpj = $request->input('cnpj');
        $ie = $request->input('ie');
        $telefone = $request->input('telefone');
        $endereco = $request->input('endereco');

        $empresa = new Empresa();
        $empresa->setAttribute('nome', $nome);
        $empresa->setAttribute('sla_id', $sla_id);
        $empresa->setAttribute('cnpj', $cnpj);
        $empresa->setAttribute('ie', $ie);
        $empresa->setAttribute('telefone', $telefone);
        $empresa->setAttribute('endereco', $endereco);
        $empresa->save();

        return redirect()->route('empresa.index')->with('status', 'Empresa cadastrada com sucesso!');

    }

    public function edit(Empresa $empresa)
    {
        $slas = Sla::all();
        return view('empresa.editar', [
            'empresa' => $empresa,
            'slas' => $slas,
        ]);
    }

    public function update(Request $request, Empresa $empresa)
    {
        $nome = $request->input('nome');
        $sla_id = $request->input('sla_id');
        $cnpj = $request->input('cnpj');
        $ie = $request->input('ie');
        $telefone = $request->input('telefone');
        $endereco = $request->input('endereco');

        $empresa->setAttribute('nome', $nome);
        $empresa->setAttribute('sla_id', $sla_id);
        $empresa->setAttribute('cnpj', $cnpj);
        $empresa->setAttribute('ie', $ie);
        $empresa->setAttribute('telefone', $telefone);
        $empresa->setAttribute('endereco', $endereco);
        $empresa->save();

        return redirect()->route('empresa.index')->with('status', 'Empresa atualizada com sucesso!');

    }

    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $empresa->delete();

        return redirect()->route('empresa.index')->with('status', 'Empresa removida com sucesso!');
    }
}
