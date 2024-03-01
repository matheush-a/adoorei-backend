<?php

namespace App\Services;

use App\Models\ProductSale;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleService
{
    protected Sale $sale;
    protected ProductSale $productSale;

    function __construct(Sale $sale, ProductSale $productSale)
    {
        $this->sale = $sale;
        $this->productSale = $productSale;
    }

    public function store($data)
    {
        DB::transaction(function () use ($data) {
            $sale = $this->sale->newInstance($data->except('products'));
            $sale->save();

            $products = $data['products'];

            foreach($products as $index => $product) {
                $products[$index]['sale_id'] = $sale->id;
            }

            $this->productSale->store($products);
        });
    }

    public function addProducts($products)
    {
        $this->productSale->store($products);
    }
}