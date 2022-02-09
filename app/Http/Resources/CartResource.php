<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'watch_id' => $this->watch_id,
            'user_id' => $this->user_id,
            'brand' => $this->brand,
            'series' => $this->series,
            'model' => $this->model,
            'case_size' => $this->case_size,
            'bracelet_material' => $this->bracelet_material,
            'dial_color' => $this->dial_color,
            'status' => $this->status,
        ];
    }
}
