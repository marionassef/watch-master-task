<?php

namespace App\Http\Controllers;

use App\DTO\BuyItemDTO;
use App\DTO\GetCartDTO;
use App\DTO\StoreCartDTO;
use App\Helpers\CustomResponse;
use App\Http\Requests\BuyItemRequest;
use App\Http\Requests\GetCartRequest;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

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
     * @param \App\Http\Requests\StoreCartRequest $storeCartRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CustomQueryException
     */
    public function store(StoreCartRequest $storeCartRequest): JsonResponse
    {
        $this->cartService->store(StoreCartDTO::fromRequest($storeCartRequest->validated()));
        return CustomResponse::successResponse(__('success'));
    }

    /**
     * @param \App\Http\Requests\GetCartRequest $getCartRequest
     * @return JsonResponse
     * @throws \App\Exceptions\CustomQueryException
     * @throws \App\Exceptions\CustomValidationException
     */
    public function getCart(GetCartRequest $getCartRequest): JsonResponse
    {
        return CustomResponse::successResponse(__('success'),
            new CartResource($this->cartService->getCart(GetCartDTO::fromRequest($getCartRequest->validated()))));
    }

    /**
     * @param BuyItemRequest $buyItemRequest
     * @return JsonResponse
     * @throws \App\Exceptions\CustomQueryException
     */
    public function buyProduct(BuyItemRequest $buyItemRequest): JsonResponse
    {
        $this->cartService->buyProduct(BuyItemDTO::fromRequest($buyItemRequest->validated()));
        return CustomResponse::successResponse(__('success'));
    }
}
