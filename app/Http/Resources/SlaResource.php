<?php

namespace App\Http\Resources;

use App\Empresa;
use App\Prioridade;
use App\PrioridadesSla;
use Illuminate\Http\Resources\Json\JsonResource;

class SlaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $prioridadesSla = PrioridadesSla::all();
        $prioridadesSla = $prioridadesSla->where('sla_id', $this->id);
        $prioridades = [];

        foreach ($prioridadesSla as $item):
            $prioridades[] = $item->prioridade_id;
        endforeach;

        $prioridades = Prioridade::whereIn('id', $prioridades)->get();
        $this->setAttribute('prioridades', $prioridades);

        return parent::toArray($request);
    }
}
