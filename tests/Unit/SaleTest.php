<?php

namespace Tests\Unit;

use App\Models\Sale;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use DatabaseTransactions;

    public function test_class_constructor()
    {
        $attributes = [
            'amount' => '8100',
            'is_active' => true,
        ];

        $sale = new Sale($attributes);

        $this->assertSame('8100', $sale->amount);
        $this->assertSame(true, $sale->is_active);
    }

    public function test_sales_indexing()
    {
        $response = $this->get('/sale');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_sale_show()
    {
        $id = 1;
        $response = $this->get("/sale/$id");
        $response->assertStatus(Response::HTTP_OK);

        if ($response->getContent() !== "{}") {
            $response->assertJson(fn (AssertableJson $json) =>
                $json->where('id', $id)
                    ->where('amount', 9000)
                    ->where('is_active', 1)
                    ->whereType('product_sales', 'array')
                    ->etc()
            );
        }
    }

    public function test_empty_sale_show()
    {
        $response = $this->get('/sale/300');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([], $response->getContent());
    }

    public function test_sale_store() {
        $response = $this->post('/sale', [
                "amount" => 9000,
                "products" => [
                  [
                    "product_id" => 1,
                    "amount" => 1
                  ],
                  [
                    "product_id" => 2,
                    "amount" => 2
                  ]
            ]
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('"Sale successfully created."', $response->getContent());
    }

    public function test_sale_store_failed_validation() {
        $response = $this->post('/sale', [
            "amount" => 9000,
            "products" => [
                [
                    "product_id" => 4,
                    "amount" => 0
                ],
                [
                    "product_id" => 2,
                    "amount" => 2
                ]
            ]
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_sale_add_products() {
        $response = $this->post('/sale/add-products', [
            "products" => [
                [
                    "product_id" => 2,
                    "amount" => 6,
                    "sale_id" => 1
                ],
            ]
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertEquals('"Products successfully added."', $response->getContent());
    }

    public function test_sale_add_products_failed_validation() {
        $response = $this->post('/sale/add-products', [
            "products" => [
                [
                    "product_id" => 4,
                    "amount" => 0
                ],
                [
                    "product_id" => 2,
                    "amount" => 2
                ]
                ]
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_sale_cancel() {
        $id = 1;

        $response = $this->patch('/sale', [
            "id" => $id
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals('"Sale #' . $id . ' successfully cancelled."', $response->getContent());
    }

    public function test_sale_cancel_failed_validation() {
        $response = $this->patch('/sale', [
            "id" => 'AAA'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
