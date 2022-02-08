<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class StoreCartDTO extends DataTransferObject
{
    public $watch_id;
    public $user_id;
    public $brand;
    public $series;
    public $model;
    public $case_size;
    public $bracelet_material;
    public $dial_color;
    public $status;

    public static function fromRequest(array $parameters = []): self
    {
        return new self([
            'watch_id' => $parameters['watch_id'],
            'brand' => $parameters['brand'],
            'series' => $parameters['series'],
            'model' => $parameters['model'],
            'case_size' => $parameters['case_size'],
            'bracelet_material' => $parameters['bracelet_material'],
            'dial_color' => $parameters['dial_color'],
            'status' => $parameters['status'],
        ]);
    }

}
