<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UsuarioCollection;
use App\Http\Resources\UsuarioResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return new UsuarioCollection(User::all());
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

        return new UsuarioResource($user);
    }

    public function show(User $user)
    {
        return new UsuarioResource($user);
    }

    public function update(Request $request, User $user)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $tipo = $request->input('tipo');
        $senha = $request->input('senha');
        $empresa_id = $request->input('empresa_id');

        if (isset($name))
            $user->setAttribute('name', $name);
        if (isset($email))
            $user->setAttribute('email', $email);
        if (isset($tipo))
            $user->setAttribute('tipo', intval($tipo));
        if (isset($senha))
            $user->setAttribute('password', Hash::make($senha));
        if (isset($empresa_id))
            $user->setAttribute('empresa_id', intval($empresa_id));

        $user->save();

        return new UsuarioResource($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return 'Removido com sucesso!';
    }
}
