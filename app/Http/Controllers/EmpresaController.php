<?php

namespace App\Http\Controllers;

use App\Dispositivo;
use App\Empresa;
use App\Sla;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;

class EmpresaController extends Controller
{
    public function index($orderby = null, $order = null)
    {
        if (isset($order) && isset($orderby)) {
            $empresas = DB::table('empresas')->select('id', 'nome', 'telefone', 'cnpj', 'endereco')->orderBy($orderby, $order)->get()->toArray();
        } else {
            $empresas = DB::table('empresas')->select('id', 'nome', 'telefone', 'cnpj', 'endereco')->get()->toArray();
        }
        foreach ($empresas as $key => $empresa) {
            $funcionarios = DB::table('users')->select('id', 'name')->where('empresa_id', $empresa->id)->get()->toArray();
            foreach ($funcionarios as $chave => $funcionario) {
                $funcionarios[$chave] = (Array)$funcionario;
            }
            $modal = array(
                'title' => 'Detalhes da Empresa ' . $empresa->nome,
                'data' => [
                    [
                        'title' => 'Funcionários',
                        'thead' => ['id', 'Nome'],
                        'tbody' => $funcionarios,
                        'route' => 'usuario'
                    ]],
                'buttons' => ['back' => 'Voltar', 'exclude' => 'Excluir']
            );
            $empresa = (Array)$empresa;
            $empresa['modal'] = $modal;
            $empresas[$key] = $empresa;
        }

        $table = array(
            'thead' => ['id' => '#','nome' => 'Nome', 'Telefone', 'CNPJ', 'Endereço'],
            'tbody' => $empresas,
            'actions' => ['edit' => 'Editar'],
            'tfoot' => ['id' => '#','nome' => 'Nome', 'Telefone', 'CNPJ', 'Endereço'],
        );


        return view('listar', [
            'title' => 'Empresas',
            'action' => 'Nova Empresa',
            'route' => 'empresa',
            'table' => $table,
            'order' => [
                'orderby' => $orderby,
                'order' => $order
            ]
        ]);
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
        try {
            $empresa = Empresa::find($id);
            $itens = Dispositivo::where('empresa_id', $id)->get();
            foreach ($itens as $item) {
                $item->delete();
            }
            $funcionarios = User::where('empresa_id', $id)->get();
            foreach ($funcionarios as $item) {
                $item->delete();
            }
            $empresa->delete();

        } catch (Exception $e) {
            var_dump($e);
            exit;
//                return redirect()->route('empresa.index')->with('status', 'Falha ao remover empresa!');
        }
    }
}
