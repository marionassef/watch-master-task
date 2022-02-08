<?php

namespace App\Repositories;

use App\Constants\ProductStatus;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class ProductRepository extends RedisAbstractRepository
{
    public const PRODUCTS = "products";

    public function store($data): void
    {
        $data->id = (string) Str::uuid();
        $data->status = ProductStatus::AVAILABLE;
        $products = $this->findOneBy(self::PRODUCTS);
        $products = $this->handleInitialCase($products);
        $products[] = (object)$data->toArray();
        $this->updateProduct($products);
    }

    public function updateProduct($data): void
    {
        Redis::set(self::PRODUCTS, json_encode($data));
    }

    /**
     * @throws \App\Exceptions\CustomQueryException
     */
    private function handleInitialCase($products){
        if(!$products){
            Redis::set(self::PRODUCTS, json_encode([]));
        }
        return $this->findOneBy(self::PRODUCTS);
    }

}
