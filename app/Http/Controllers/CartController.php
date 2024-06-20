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
        $productSlug = $request->productSlug;
        $userId = 1 ?? auth()->id;

        $product = Product::whereSlug($productSlug)->first();

        if (!$product) {
            throw new Exception('Product not exists.');
        }

        $existsCart = Cart::where('is_active', 1)->where('product_id', $product->id)->where('user_id', $userId)->first();
        if(!$existsCart){
            session()->forget('cart');
        }
        
        $quantity = $existsCart->quantity ?? 1;

        $cart = $request->session()->get('cart', []);
        if (isset($cart[$productSlug])) {
            $cart[$productSlug]['quantity']++;
        } else {
            $cart[$productSlug] = [
                'product_id' => $productSlug,
                'quantity' => $quantity,
            ];
        }
    
        $request->session()->put('cart', $cart);
        
        $total = $product['price'] * $cart[$productSlug]['quantity'];

        Cart::updateOrCreate(
            [
                'product_id' => $product['id'],
                'user_id'    => $userId
            ],
            [
                'quantity' => $cart[$productSlug]['quantity'],
                'total'  => $total
            ]
        );

        return redirect()->route('cart.show')->with('success', 'Product added to cart successfully!');
    }

    public function showCart()
    {
        $carts = Cart::with('product')->get();
        $subtotal = Cart::sum('total');
        $shippingCharge = 10;
        $totalWithShipping = $subtotal + $shippingCharge;

        return view('cart.show', compact('carts','subtotal','totalWithShipping','shippingCharge'));
    }

    public function updateItem(Request $request, $id)
    {
        $quantity = $request->quantity;

        $cart = session()->get('cart');

        $cart = Cart::find($id);

        if(!$cart){
            return redirect()->route('cart.show')->with('error', 'Product not found in cart');
        }

        $total = $cart->product->price * $quantity;
        
        $cart->update([
            'quantity' => $quantity,
            'total'    => $total
        ]);

        $subtotal = Cart::sum('total');
        $shippingCharge = 10;
        $totalWithShipping = $subtotal + $shippingCharge;
        
        return response()->json([
            'data' => $cart,
            'calculation' => [
                'subtotal' => $subtotal,
                'totalWithShipping' => $totalWithShipping
            ],
            'success' => 'Cart updated successfully'
        ]);
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        Cart::find($id)->update(['is_active' => 0]);

        return redirect()->route('cart.show')->with('success', 'Product removed from cart successfully');
    }
}
