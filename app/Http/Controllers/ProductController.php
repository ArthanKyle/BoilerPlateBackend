<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Product::query();
    
        // ✅ Check if category_id is provided in the request
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        $products = $query->get();
    
        return response()->json([
            'message' => 'Products retrieved successfully',
            'products' => $products
        ], 200);
    }
    
}
