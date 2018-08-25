<?php

namespace App\Http\Resources;

use App\Prioridade;
use App\PrioridadesSla;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SlaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        foreach ($this->collection as $sla):

            $prioridadesSla = PrioridadesSla::all();
            $prioridadesSla = $prioridadesSla->where('sla_id', $sla->id);
            $prioridades = [];

            foreach ($prioridadesSla as $item):
                $prioridades[] = $item->prioridade_id;
            endforeach;

            $prioridades = Prioridade::whereIn('id', $prioridades)->get();
            $sla->setAttribute('prioridades', $prioridades);
       endforeach;

        return parent::toArray($request);

    }

}
