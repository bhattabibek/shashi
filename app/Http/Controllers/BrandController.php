<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        // Retrieve all products
        $products = Brand::all();
        
        return view('pages.brand', compact('products'));
    }
    
    public function filter(Request $request)
    {
        // Retrieve filtered products based on request parameters
        $query = Brand::query();

        // Example of filtering by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Example of filtering by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->get();

        return view('products.index', compact('products'));
    }
}
