<?php

namespace App\Http\Controllers;

use App\DTO\BuyProductDTO;
use App\DTO\StoreProductDTO;
use App\Helpers\CustomResponse;
use App\Http\Requests\BuyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * @var \App\Services\ProductService
     */
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CustomQueryException
     */
    public function list(): JsonResponse
    {
        return CustomResponse::successResponse(__('success'), $this->productService->list());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CustomQueryException
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $this->productService->store(StoreProductDTO::fromRequest($request->validated()));

        return CustomResponse::successResponse(__('success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\BuyProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CustomQueryException|\App\Exceptions\CustomValidationException
     */
    public function buy(BuyProductRequest $request): JsonResponse
    {
        $this->productService->updateProduct(BuyProductDTO::fromRequest($request->validated()));

        return CustomResponse::successResponse(__('success'));
    }
}
