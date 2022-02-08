<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class StoreProductDTO extends DataTransferObject
{
    public $brand;
    public $series;
    public $model;
    public $bracelet_material;
    public $dial_color;
    public $seller_full_name;
    public $seller_id_number;
    public $seller_phone_number;
    public $seller_email;
    public $type;
    public $id;
    public $status;

    public static function fromRequest(array $parameters = []): self
    {
        return new self([
            'brand' => $parameters['brand'],
            'series' => $parameters['series'],
            'model' => $parameters['model'],
            'bracelet_material' => $parameters['bracelet_material'],
            'dial_color' => $parameters['dial_color'],
            'seller_full_name' => $parameters['seller_full_name'],
            'seller_id_number' => $parameters['seller_id_number'],
            'seller_phone_number' => $parameters['seller_phone_number'],
            'seller_email' => $parameters['seller_email'],
            'type' => $parameters['type'],
        ]);
    }

}
