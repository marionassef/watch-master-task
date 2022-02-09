<?php

namespace Tests\Feature\Http\Controllers;

use App\Constants\ProductStatus;
use Illuminate\Support\Str;
use Tests\TestCase;

class CartControllerTest extends TestCase
{

    public function testBuyProduct(): void
    {
        $response = $this->post('api/cart/store', [
            'brand' => 'Rolex',
            'series' => '7',
            'watch_id' => (string) Str::uuid(),
            'model' => 'mbx2022',
            'bracelet_material' => 'metal',
            'case_size' => 10,
            'dial_color' => ['black'],
            'status' => ProductStatus::AVAILABLE,
        ])->assertStatus(200);

        $userId = json_decode($response->getContent())->data->user_id;

        $this->post('api/product/buy', [
            'user_id' => $userId,
        ])->assertStatus(200);

        $this->post('api/cart/get', [
            'user_id' => $userId,
        ])->assertStatus(400);
    }

    public function testBuyProductAlreadyInOtherCarts(): void
    {
        $watchId = (string) Str::uuid();
        $cart1 = $this->post('api/cart/store', [
            'brand' => 'Rolex',
            'series' => '7',
            'watch_id' => $watchId,
            'model' => 'mbx2022',
            'bracelet_material' => 'metal',
            'case_size' => 10,
            'dial_color' => ['black'],
            'status' => ProductStatus::AVAILABLE,
        ])->assertStatus(200);

        $cart2 = $this->post('api/cart/store', [
            'brand' => 'Rolex',
            'series' => '7',
            'watch_id' => $watchId,
            'model' => 'mbx2022',
            'bracelet_material' => 'metal',
            'case_size' => 10,
            'dial_color' => ['black'],
            'status' => ProductStatus::AVAILABLE,
        ])->assertStatus(200);

        $userIdCart1 = json_decode($cart1->getContent())->data->user_id;
        $userIdCart2 = json_decode($cart2->getContent())->data->user_id;

        $this->post('api/product/buy', [
            'user_id' => $userIdCart2,
        ])->assertStatus(200);

        $cart1AfterBuy = $this->post('api/cart/get', [
            'user_id' => $userIdCart1,
        ])->assertStatus(200);

        $this->assertEquals(0, json_decode($cart1AfterBuy->getContent())->data->status);
    }

    public function testBuyProductInvalidData(): void
    {
        $this->post('api/cart/store', [
            'brand' => 'Rolex',
        ])->assertStatus(400);
    }

    public function testStore()
    {
        $this->withoutExceptionHandling()->post('api/cart/store', [
            'brand' => 'Rolex',
            'series' => '7',
            'watch_id' => (string) Str::uuid(),
            'model' => 'mbx2022',
            'bracelet_material' => 'metal',
            'case_size' => 10,
            'dial_color' => ['black'],
            'status' => ProductStatus::AVAILABLE,
        ])->assertStatus(200)->assertJsonStructure([
            "data" => [
                'user_id',
                'series',
                'watch_id',
                'model',
                "bracelet_material",
                "case_size",
                "status",
            ],
        ]);

    }

    public function testGetCart()
    {
        $response = $this->post('api/cart/store', [
            'brand' => 'Rolex',
            'series' => '7',
            'watch_id' => (string) Str::uuid(),
            'model' => 'mbx2022',
            'bracelet_material' => 'metal',
            'case_size' => 10,
            'dial_color' => ['black'],
            'status' => ProductStatus::AVAILABLE,
        ])->assertStatus(200);

        $userId = json_decode($response->getContent())->data->user_id;

        $this->post('api/cart/get', [
            'user_id' => $userId,
        ])->assertStatus(200)->assertJsonStructure([
            "data" => [
                'user_id',
                'series',
                'watch_id',
                'model',
                "bracelet_material",
                "case_size",
                "status",
            ],
        ]);
    }

    public function testGetCartInvalidData()
    {
        $this->post('api/cart/get', [
            'user_id' => (string) Str::uuid(),
        ])->assertStatus(400);
    }
}
