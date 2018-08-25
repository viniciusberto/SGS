<?php

namespace App\Http\Resources;

use App\User;
use function foo\func;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UsuarioCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->each(function ($item, $index){
            $item->tipo = User::verificarTipo($item->tipo);
        });
        return parent::toArray($request);
    }
}
