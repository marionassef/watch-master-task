<?php

namespace App\Services;

use App\Constants\ProductStatus;
use App\DTO\BuyProductDTO;
use App\DTO\StoreProductDTO;
use App\Exceptions\CustomValidationException;
use App\Repositories\ProductRepository;
use function PHPUnit\Framework\arrayHasKey;

class ProductService
{
    /**
     * @var \App\Repositories\ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @throws \App\Exceptions\CustomQueryException
     */
    public function list(){
        return $this->productRepository->findOneBy($this->productRepository::PRODUCTS);
    }

    /**
     * @throws \App\Exceptions\CustomQueryException
     */
    public function store(StoreProductDTO $storeProductDTO): void
    {
        $this->productRepository->store($storeProductDTO);
    }

    /**
     * @throws \App\Exceptions\CustomQueryException
     * @throws \App\Exceptions\CustomValidationException
     */
    public function updateProduct(BuyProductDTO $buyProductDTO): void
    {
        $listOfProducts = $this->productRepository->findOneBy($this->productRepository::PRODUCTS);
        array_column($listOfProducts, 'id');
        $checkIfExist  = false;
        foreach ( $listOfProducts as $key=>$product){
            if($product['id'] === $buyProductDTO->product_id){
                dump($key, $product);
                unset($listOfProducts[$key]);
                $product['status'] = ProductStatus::SOLD;
                $listOfProducts[] = (object)$product;
                $this->productRepository->updateProduct($listOfProducts);
                $checkIfExist = true;
                break;
            }
        }
        if (!$checkIfExist){
            throw new CustomValidationException(__("messages.product_sold_out"));
        }
    }
}
