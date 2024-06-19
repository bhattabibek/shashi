<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Request;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all(string $filterData)
    {
        $products =  Product::query();
        if ($filterData) {
            $products = $products->where('title', 'like', "%$filterData")
                                 ->orWhere('price', 'like', "%$filterData")
                                  ->get();
        } else {
            $products = $products->get();
        }
        return $products;
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(array $data, $id)
    {
        $user = Product::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = Product::findOrFail($id);
        $user->delete();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }
}
