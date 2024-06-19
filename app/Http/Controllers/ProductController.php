<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {
    }

    public function index(Request $request)
    {
        $filterData = $request->search ?? $request->price ??'';
     
        $products = $this->productService->all($filterData);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $user = $this->productService->create($data);

        return redirect()->route('users.show', $user->id);
    }

    public function show($id)
    {
        $product = $this->productService->find($id);
        return view('products.detail', compact('product'));
    }

    public function edit($id)
    {
        $user = $this->productService->find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'sometimes|confirmed'
        ]);

        $user = $this->productService->update($data, $id);

        return redirect()->route('users.show', $user->id);
    }

    public function destroy($id)
    {
        $this->productService->delete($id);

        return redirect()->route('users.index');
    }
    public function search(Request $request)
    {
        $search = 'product' ?? $request->input('search');
        $products = Product::where('title', 'like', "%$search%")->get();

        return view('products.detail', compact('products'));
    }
}
