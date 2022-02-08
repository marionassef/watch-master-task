<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    /**
     * @var \App\Services\CartService
     */
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreCartRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCartRequest $storeCartRequest)
    {
        Redis::set('name', 'MARIO');

        return Response::json(['name' => Redis::get('name')]);
    }

    /**
     * @param AdminDetailsRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\CustomQueryException
     */
    public function details(AdminDetailsRequest $request): JsonResponse
    {
        return CustomResponse::successResponse(__('success'), $this->adminService->getOneBy($request->validated()));
    }

    /**
     * @param AdminUpdateRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\CustomQueryException
     */
    public function update(AdminUpdateRequest $request): JsonResponse
    {
        return CustomResponse::successResponse(__('success'), $this->adminService->update($request->validated()));
    }
}
