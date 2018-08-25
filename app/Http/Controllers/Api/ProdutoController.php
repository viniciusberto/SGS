<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProdutoCollection;
use App\Http\Resources\ProdutoResource;
use App\Produto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdutoController extends Controller
{
    public function index()
    {
        return new ProdutoCollection(Produto::all());
    }

    public function store(Request $request)
    {
        $nome = $request->input('nome');
        $valor = $request->input('valor');

        $produto = new Produto();
        $produto->setAttribute('nome', $nome);
        $produto->setAttribute('valor', floatval($valor));
        $produto->save();

        return new ProdutoResource($produto);
    }

    public function show(Produto $produto)
    {
        return new ProdutoResource($produto);
    }

    public function update(Request $request, Produto $produto)
    {
        $nome = $request->input('nome');
        $valor = $request->input('valor');

        if (isset($nome))
            $produto->setAttribute('nome', $nome);
        if (isset($valor))
            $produto->setAttribute('valor', floatval($valor));
        $produto->save();

        return new ProdutoResource($produto);
    }

    public function destroy($id)
    {
       $produto = Produto::find($id);
       $produto->delete();
       return 'Removido com sucesso!';
    }
}
