<?php

namespace App\Http\Resources;

use App\PrioridadesSla;
use App\Sla;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PrioridadeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        foreach ($this->collection as $prioridade):

            $prioridadesSla = PrioridadesSla::all();
            $prioridadesSla = $prioridadesSla->where('prioridade_id', $prioridade->id);
            $slas = [];

            foreach ($prioridadesSla as $item):
                $slas[] = $item->sla_id;
            endforeach;

            $slas = Sla::whereIn('id', $slas)->get();
            $prioridade->setAttribute('slas', $slas);
        endforeach;

        return parent::toArray($request);
    }
}
