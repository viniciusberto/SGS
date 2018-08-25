<?php

namespace App\Http\Controllers\Api;

use App\Dispositivo;
use App\Http\Resources\DispositivoCollection;
use App\Http\Resources\DispositivoResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\Resource;

class DispositivoController extends Controller
{
    public function index()
    {
        return new DispositivoCollection(Dispositivo::all());
    }

    public function store(Request $request)
    {
        $descricao = $request->input('descricao');

        $dispositivo = new Dispositivo();
        $dispositivo->setAttribute('descricao', $descricao);
        $dispositivo->save();

        return new DispositivoResource($dispositivo);

    }

    public function show(Dispositivo $dispositivo)
    {
        return new DispositivoResource($dispositivo);
    }

    public function update(Request $request, Dispositivo $dispositivo)
    {
        $descricao = $request->input('descricao');

        if (isset($descricao))
        $dispositivo->setAttribute('descricao', $descricao);
        $dispositivo->save();

        return new DispositivoResource($dispositivo);
    }

    public function destroy($id)
    {
        $dispositivo = Dispositivo::find($id);
        $dispositivo->delete();
        return 'Removido com sucesso!';
    }
}
