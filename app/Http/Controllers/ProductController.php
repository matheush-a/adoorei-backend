<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected Product $product;

    function __construct(Product $product) 
    {
        $this->product = $product;
    }

    public function index() 
    {
        return response()->json($this->product->all(), Response::HTTP_OK);
    }
}
