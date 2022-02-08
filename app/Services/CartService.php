<?php

namespace App\Services;

use App\Repositories\CartRepository;

class CartService
{
    /**
     * @var \App\Repositories\CartRepository
     */
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }
}
