<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->tipo = User::verificarTipo($this->tipo);
        return parent::toArray($request);
    }
}
