<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    public function test_class_constructor()
    {
        $attributes = [
            'name' => 'Celular Teste',
            'price' => '1900',
            'description' => 'Descrição Teste',
        ];

        $product = new Product($attributes);

        $this->assertSame('Celular Teste', $product->name);
        $this->assertSame('1900', $product->price);
        $this->assertSame('Descrição Teste', $product->description);
    }

    public function test_products_indexing()
    {
        $response = $this->get('/product');
        $response->assertStatus(Response::HTTP_OK);
    }
}
