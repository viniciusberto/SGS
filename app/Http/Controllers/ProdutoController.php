<?php

namespace App\Http\Controllers;

use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class ProdutoController extends Controller
{
    public function index($orderBy = null, $order = null)
    {
//        $produtos = Produto::all();
//        return view('produto.listar', ['produtos' => $produtos]);


        if (isset($order) && isset($orderBy)) {
            $produtos = DB::table('produtos')
                ->select('*')->orderBy($orderBy, $order)->get()->toArray();
        } else {
            $produtos = DB::table('produtos')
                ->select('*')->get()->toArray();
        }

        foreach ($produtos as $key => $produto) {
            $produto = (Array)$produto;
            unset($produto['created_at']);
            unset($produto['updated_at']);

            $produtos[$key] = $produto;
        }

        $table = array(
            'thead' => ['#', 'nome' => 'Nome', 'valor' => 'Valor'],
            'tbody' => $produtos,
            'actions' => [
                'edit' => 'Editar',
                'trash' => 'Excluir'
            ],
            'tfoot' => ['#', 'nome' => 'Nome', 'valor' => 'Valor'],
        );


        return view('listar', [
            'title' => 'Produtos',
            'action' => 'Adicionar Novo',
            'route' => 'produto',
            'order' => [
                'orderby' => $orderBy,
                'order' => $order
            ],
            'table' => $table,
        ]);


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
        return view('produto.editar', ['produto' => $produto]);
    }

    public function update(Request $request, Produto $produto)
    {
        $nome = $request->input('nome');
        $valor = $request->input('valor');
        $produto->setAttribute('nome', $nome);
        $produto->setAttribute('valor', floatval($valor));
        $produto->save();

        return redirect()->route('produto.index')->with('status', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::find($id);
        $produto->delete();

        return redirect()->route('produto.index')->with('status', 'Produto removido com sucesso!');
    }
}
