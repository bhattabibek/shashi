<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Models\Category;

class HomePageController extends Controller
{
    public function __construct(
        protected ProductService $productService
      ) {
      }
      
    public function index(){
        $products = $this->productService->all();
  
        $categories= Category::with('subcategory')->get();
    
        return view('pages.home',compact('products','categories'));
    }
}
