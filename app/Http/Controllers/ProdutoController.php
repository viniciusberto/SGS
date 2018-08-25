<?php

namespace App\Http\Controllers;

use App\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return view('produto.listar', ['produtos' => $produtos]);
    }

    public function create()
    {
        return view('produto.cadastrar');
    }

    public function store(Request $request)
    {
        $nome = $request->input('nome');
        $valor = $request->input('valor');

        $produto = new Produto();
        $produto->setAttribute('nome', $nome);
        $produto->setAttribute('valor', floatval($valor));
        $produto->save();

        return redirect()->route('produto.index')->with('status' . 'Produto cadastrado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        return view('produto.editar',['produto' => $produto]);
    }

    public function update(Request $request, Produto $produto)
    {
        $nome = $request->input('nome');
        $valor = $request->input('valor');
        $produto->setAttribute('nome',$nome);
        $produto->setAttribute('valor', floatval($valor));
        $produto->save();

        return redirect()->route('produto.index')->with('status','Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);
        $produto->delete();

        return redirect()->route('produto.index')->with('status', 'Produto removido com sucesso!');
    }
}
