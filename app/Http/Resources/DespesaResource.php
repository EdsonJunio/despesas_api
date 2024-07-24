<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DespesaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'data' => $this->data,
            'usuario_id' => $this->usuario_id,
            'valor' => $this->valor,
        ];
    }
}
