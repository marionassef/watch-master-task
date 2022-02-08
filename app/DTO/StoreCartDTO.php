<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class StoreCartDTO extends DataTransferObject
{
    public $product_id;

    public static function fromRequest(array $parameters = []): self
    {
        return new self([
            'product_id' => $parameters['product_id'],
        ]);
    }

}
