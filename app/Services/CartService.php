<?php

namespace App\Services;

use App\Constants\ProductStatus;
use App\DTO\BuyItemDTO;
use App\DTO\GetCartDTO;
use App\DTO\StoreCartDTO;
use App\Exceptions\CustomValidationException;
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

    /**
     * @throws \App\Exceptions\CustomQueryException
     */
    public function store(StoreCartDTO $storeProductDTO): void
    {
        $this->cartRepository->store($storeProductDTO);
    }

    /**
     * @param \App\DTO\GetCartDTO $getCartDTO
     * @return mixed
     * @throws \App\Exceptions\CustomQueryException
     * @throws \App\Exceptions\CustomValidationException
     */
    public function getCart(GetCartDTO $getCartDTO)
    {
        $listOfCarts = $this->cartRepository->findOneBy($this->cartRepository::CARTS);
        foreach ($listOfCarts as $product) {
            if ($product['user_id'] === $getCartDTO->user_id) {
                return (object)$product;
            }
        }
        throw new CustomValidationException(__("messages.cart_not_found"));
    }

    /**
     * @throws \App\Exceptions\CustomQueryException
     */
    public function buyProduct(BuyItemDTO $buyItemDTO): void
    {
        $listOfCarts = $this->cartRepository->findOneBy($this->cartRepository::CARTS);
        $watchId = null;
        foreach ($listOfCarts as $key => $cart) {
            if ($cart['user_id'] === $buyItemDTO->user_id) {
                $watchId = $cart['watch_id'];
                unset($listOfCarts[$key]);
                $this->cartRepository->updateCarts($listOfCarts);
                break;
            }
        }
        foreach ($listOfCarts as $key => $cart) {
            if ($cart['watch_id'] === $watchId) {
                unset($listOfCarts[$key]);
                $cart['status'] = ProductStatus::SOLD;
                $listOfCarts[] = (object)$cart;
                $this->cartRepository->updateCarts($listOfCarts);
            }
        }
    }
}
