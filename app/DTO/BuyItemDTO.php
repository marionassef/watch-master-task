<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class BuyItemDTO extends DataTransferObject
{
    public $user_id;

    public static function fromRequest(array $parameters = []): self
    {
        return new self([
            'user_id' => $parameters['user_id'],
        ]);
    }

}
