<?php

namespace App\Repositories;

use App\Constants\ProductStatus;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CartRepository extends RedisAbstractRepository
{
    public const CARTS = "carts";

    public function store($data): void
    {
        $data->user_id = (string) Str::uuid();
        $carts = $this->findOneBy(self::CARTS);
        $carts = $this->handleInitialCase($carts);
        $carts[] = (object)$data->toArray();
        $this->updateCarts($carts);
    }

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
