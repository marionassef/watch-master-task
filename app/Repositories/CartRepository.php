<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CartRepository extends RedisAbstractRepository
{
    /**
     * @param \App\DTO\StoreCartDTO $storeCartDTO
     * @return object
     */
    public function store($storeCartDTO): object
    {
        $userId = Str::random(32);
        $cart = (object)$storeCartDTO->toArray();
        $cart->user_id = $userId;
        $this->updateCarts($userId, $cart);
        return $cart;
    }

    /**
     * @param $userId
     * @param $data
     * @return void
     */
    public function updateCarts($userId, $data): void
    {
        Redis::set($userId, json_encode($data));
    }
}
