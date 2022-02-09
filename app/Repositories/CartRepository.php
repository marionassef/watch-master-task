<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CartRepository extends RedisAbstractRepository
{
    public const CARTS = "carts";

    /**
     * @param $data
     * @throws \App\Exceptions\CustomQueryException
     */
    public function store($data): object
    {
        $data->user_id = (string) Str::uuid();
        $carts = $this->findOneBy(self::CARTS);
        $carts = $this->handleInitialCase($carts);
        $cart = (object)$data->toArray();
        $carts[] = $cart;
        $this->updateCarts($carts);
        return $cart;
    }

    /**
     * @param $data
     * @return void
     */
    public function updateCarts($data): void
    {
        Redis::set(self::CARTS, json_encode($data));
    }

    /**
     * @throws \App\Exceptions\CustomQueryException
     */
    private function handleInitialCase($carts){
        if(!$carts){
            Redis::set(self::CARTS, json_encode([]));
        }
        return $this->findOneBy(self::CARTS);
    }
}
