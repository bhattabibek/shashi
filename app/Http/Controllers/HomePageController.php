<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class HomePageController extends Controller
{
    public function __construct(
        protected ProductService $productService
      ) {
      }
      
    public function index(){
        $products = $this->productService->all();

        return view('pages.home',compact('products'));
    }
}
