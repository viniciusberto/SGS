<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index($orderBy = null, $order = null)
    {
        if (isset($order) && isset($orderBy)) {
            $usuarios = DB::table('users')
                ->join('empresas', 'users.empresa_id', '=', 'empresas.id')
                ->select('users.id', 'users.name', 'empresas.nome as empresa', 'users.tipo', 'users.email')->orderBy($orderBy, $order)->get()->toArray();
        } else {
            $usuarios = DB::table('users')
                ->join('empresas', 'users.empresa_id', '=', 'empresas.id')
                ->select('users.id', 'users.name', 'empresas.nome as empresa', 'users.tipo', 'users.email')->get()->toArray();
        }

        foreach ($usuarios as $key => $usuario) {
            $usuario->tipo = User::verificarTipo($usuario->tipo);
            $usuarios[$key] = (Array)$usuario;
        }

        $table = array(
            'thead' => ['#', 'name' => 'Nome', 'empresa_id' => 'Empresa', 'tipo' => 'Tipo', 'E-Mail'],
            'tbody' => $usuarios,
            'actions' => [
                'edit' => 'Editar',
                'trash' => 'Excluir'
            ],
            'tfoot' => ['#', 'name' => 'Nome', 'empresa_id' => 'Empresa', 'tipo' => 'Tipo', 'E-Mail'],
        );


        return view('listar', [
            'title' => 'Usuários',
            'action' => 'Adicionar Novo',
            'route' => 'usuario',
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
        return view('usuario.cadastrar', ['empresas' => $empresas]);
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $tipo = $request->input('tipo');
        $senha = $request->input('senha');
        $empresa_id = $request->input('empresa_id');

        $user = new User();
        $user->setAttribute('name', $name);
        $user->setAttribute('email', $email);
        $user->setAttribute('tipo', $tipo);
        $user->setAttribute('password', Hash::make($senha));
        $user->setAttribute('empresa_id', $empresa_id);
        $user->save();

        return redirect()->route('usuario.index')->with('status', 'Usuário cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $empresas = Empresa::all();
        return view('usuario.editar', [
            'empresas' => $empresas,
            'usuario' => $user,
        ]);
    }

    public function update(Request $request, $user)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $tipo = $request->input('tipo');
        $senha = $request->input('senha');
        $empresa_id = $request->input('empresa_id');

        $user = User::find($user);

        $user->setAttribute('name', $name);
        $user->setAttribute('email', $email);
        $user->setAttribute('tipo', $tipo);
        if ($senha != '') {
            $user->setAttribute('password', Hash::make($senha));
        }
        $user->setAttribute('empresa_id', $empresa_id);
        $user->save();

        return redirect()->route('usuario.index')->with('status', 'Usuário atualizado com sucesso!');
    }

    public function destroy($user)
    {
        $user = User::find($user);
        $user->delete();

        return redirect()->route('usuario.index')->with('status', 'Usuário removido com sucesso!');
    }
}
