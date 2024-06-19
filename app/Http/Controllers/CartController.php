<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productId = 10 ?? $request->product_id;
        $quantity = $request->quantity ?? 1;

        $userId = 1 ?? auth()->id;

        // $product = Product::find($productId);

        // if (!$product) {
        //     throw new Exception('Product not exists.');
        // }

        Cart::updateOrCreate(
            [
                'product_id' => $productId,
                'user_id' => $userId
            ],
            [
                'quantity' => $quantity,
                'subtotal' => null,
                'total' => null
            ]
        );

        return redirect()->route('cart.show')->with('success', 'Product added to cart successfully!');
    }

    public function showCart()
    {
        $carts = Cart::with('product')->get();
dd($carts);
        return view('cart.show', compact('carts'));
    }

    public function updateItem(Request $request, $id)
    {
        $quantity = $request->input('quantity');

        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;

            session()->put('cart', $cart);

            return redirect()->route('cart.show')->with('success', 'Cart updated successfully');
        }

        return redirect()->route('cart.show')->with('error', 'Product not found in cart');
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('success', 'Product removed from cart successfully');
    }
}
