<?php

namespace App\Http\Controllers;

use App\Lib\Validator;
use App\Models\Sale;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SaleController extends Controller
{
    protected Sale $sale;
    protected Validator $validator;
    protected SaleService $saleService;

    function __construct(Sale $sale, Validator $validator, SaleService $saleService) 
    {
        $this->sale = $sale;
        $this->validator = $validator;
        $this->saleService = $saleService;
    }

    public function addProducts(Request $request)
    {
        $this->validator->validate($request, [
            'products' => ['required', 'array'],
            'products.*.product_id'=> ['required', 'numeric', 'exists:products,id'],
            'products.*.amount'=> ['required', 'numeric', 'min:1'],
            'products.*.sale_id'=> ['required', 'numeric', 'exists:sales,id'],
        ]);

        $this->saleService->addProducts($request->products);

        return response()->json('Products successfully added.', Response::HTTP_CREATED);
    }

    public function cancel(Request $request) 
    {
        $this->validator->validate($request, [
            'id' => ['required', 'numeric', 'exists:sales'],
        ]);

        $this->sale->cancel($request->id);

        return response()->json("Sale #{$request->id} successfully cancelled.", Response::HTTP_OK);
    }

    public function index()
    {
        return response()->json($this->sale->with('productSales')->get(), Response::HTTP_OK);
    }

    public function show($id)
    {
        return response()->json($this->sale->byId($id), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $this->validator->validate($request, [
            'amount' => ['required', 'numeric'],
            'products' => ['required', 'array'],
            'products.*.product_id'=> ['required', 'numeric', 'exists:products,id'],
            'products.*.amount'=> ['required', 'numeric', 'min:1'],
        ]);
        
        $this->saleService->store($request);

        return response()->json('Sale successfully created.', Response::HTTP_CREATED);
    }
}
