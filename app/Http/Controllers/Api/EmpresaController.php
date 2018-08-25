<?php

namespace App\Http\Controllers\Api;

use App\Empresa;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmpresaController extends Controller
{
    public function index()
    {
        return new EmpresaCollection(Empresa::all());
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

        return new EmpresaResource($empresa);
    }

    public function show(Empresa $empresa)
    {
        return new EmpresaResource($empresa);
    }

    public function update(Request $request, Empresa $empresa)
    {
        $nome = $request->input('nome');
        $sla_id = intval($request->input('sla_id'));
        $cnpj = $request->input('cnpj');
        $ie = $request->input('ie');
        $telefone = $request->input('telefone');
        $endereco = $request->input('endereco');

        if(isset($nome))
        $empresa->setAttribute('nome', $nome);
        if($sla_id > 0)
        $empresa->setAttribute('sla_id', $sla_id);
        if(isset($cnpj))
        $empresa->setAttribute('cnpj', $cnpj);
        if(isset($ie))
        $empresa->setAttribute('ie', $ie);
        if(isset($telefone))
        $empresa->setAttribute('telefone', $telefone);
        if(isset($endereco))
        $empresa->setAttribute('endereco', $endereco);
        $empresa->save();

        return new EmpresaResource($empresa);
    }

    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $empresa->delete();
        return 'Removido com sucesso!';
    }
}
