<?php

namespace App\Repositories;

use App\Exceptions\CustomQueryException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RedisAbstractRepository implements AbstractRepositoryInterface
{
    /**
     * @throws \App\Exceptions\CustomQueryException
     */
    public function list()
    {
        try {
            return Redis::keys('*');
        } catch (QueryException $exception) {
            Log::debug($exception);
            throw new CustomQueryException($exception->getMessage());
        }
    }

    /**
     * @param $data
     * @throws \App\Exceptions\CustomQueryException
     */
    public function store($data)
    {
        try {
             Redis::set($data);
        } catch (QueryException $exception) {
            Log::debug($exception);
            throw new CustomQueryException($exception->getMessage());
        }
    }

    /**
     * @param $item
     * @param $data
     * @return void
     * @throws \App\Exceptions\CustomQueryException
     */
    public function update($item, $data): void
    {
        try {
            Redis::set($data);
        } catch (QueryException $exception) {
            Log::debug($exception);
            throw new CustomQueryException($exception->getMessage());
        }
    }

    /**
     * @throws \App\Exceptions\CustomQueryException
     */
    public function findOneBy($key)
    {
        try {
            return json_decode(Redis::get($key), true);
        } catch (QueryException $exception) {
            Log::debug($exception);
            throw new CustomQueryException($exception->getMessage());
        }
    }

    /**
     * @param $key
     * @return void
     * @throws \App\Exceptions\CustomQueryException
     */
    public function delete($key): void
    {
        try {
          Redis::del($key);
        } catch (QueryException $exception) {
            Log::debug($exception);
            throw new CustomQueryException($exception->getMessage());
        }
    }
}
