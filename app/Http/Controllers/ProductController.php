<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
      protected ProductService $productService
    ) {
    }

    public function index()
    {
        
        $products = $this->productService->all();
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
        $user = $this->productService->find($id);
        return view('users.show', compact('user'));
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
            'email' => 'required|unique:users,email,'.$id,
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
}        
