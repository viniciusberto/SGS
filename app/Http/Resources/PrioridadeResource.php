<?php

namespace App\Http\Resources;

use App\PrioridadesSla;
use App\Sla;
use Illuminate\Http\Resources\Json\JsonResource;

class PrioridadeResource extends JsonResource
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
        $prioridadesSla = $prioridadesSla->where('prioridade_id', $this->id);
        $slas = [];

        foreach ($prioridadesSla as $item):
            $slas[] = $item->sla_id;
        endforeach;

        $slas = Sla::whereIn('id', $slas)->get();
        $this->setAttribute('slas', $slas);

        return parent::toArray($request);
    }
}
