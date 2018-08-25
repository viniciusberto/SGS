<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $funcionarios = User::where('empresa_id', $this->id)->get();
        $this->setAttribute('funcionarios',$funcionarios);
        return parent::toArray($request);
    }
}
