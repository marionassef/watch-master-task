<?php

namespace App\Services;

use App\Constants\ItemStatus;
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
     */
    public function store(StoreCartDTO $storeProductDTO): object
    {
        return $this->cartRepository->store($storeProductDTO);
    }

    /**
     * @param \App\DTO\GetCartDTO $getCartDTO
     * @return object
     * @throws \App\Exceptions\CustomQueryException
     * @throws \App\Exceptions\CustomValidationException
     */
    public function details(GetCartDTO $getCartDTO): object
    {
        $cart = $this->cartRepository->findOneBy($getCartDTO->user_id);
        if (!$cart) {
            throw new CustomValidationException(__("messages.cart_not_found"));
        }
        return (object)$cart;
    }

    /**
     * @throws \App\Exceptions\CustomQueryException
     * @throws \App\Exceptions\CustomValidationException
     */
    public function buyItem(BuyItemDTO $buyItemDTO): void
    {
        $cart = $this->cartRepository->findOneBy($buyItemDTO->user_id);
        if (!$cart) {
            throw new CustomValidationException(__("messages.cart_not_found"));
        }

        if ($cart['status'] === ItemStatus::SOLD) {
            throw new CustomValidationException(__("messages.item_sold_out"));
        }
        $watchId = $cart['watch_id'];
        $this->cartRepository->delete($buyItemDTO->user_id);

        $listOfCarts = $this->cartRepository->list();
        foreach ($listOfCarts as $key) {
            $keyWithoutPrefix = substr($key, strpos($key, 'db_') + 3);
            $cart = $this->cartRepository->findOneBy($keyWithoutPrefix);
            if ($cart['watch_id'] === $watchId) {
                $cart['status'] = ItemStatus::SOLD;
                $this->cartRepository->updateCarts($cart['user_id'], $cart);
            }
        }
    }
}
