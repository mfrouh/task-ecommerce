<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    private function cart()
    {
        return [
            'count' => Cart::CountCart(),
            'items' => CartResource::collection(Cart::Content()),
            'total' => Cart::Total(),
        ];
    }

    public function index()
    {
        $carts = CartResource::collection(Cart::Content());

        return Inertia::render('Frontend/Cart', ['carts' => $carts]);
    }

    public function getCart()
    {
        $carts = CartResource::collection(Cart::Content());

        return $carts;
    }

    public function store(Request $request)
    {

        $cart = Cart::where('product_id', $request->product_id)->where('user_id', auth()->id())->first();
        if ($cart && $request->quantity != null && $request->quantity == 0) {
            $cart->delete();

            return response()->json(['message' => 'Success Delete Item In Cart', 'cart' => $this->cart()], 200);
        }

        if (!$cart && $request->quantity != null && $request->quantity == 0) {
            return response()->json(['message' => 'Quantity Cannot Be 0'], 422);
        }

        if (!$cart) {
            Cart::Create(['product_id' => $request->product_id, 'user_id' => auth()->user()->id, 'quantity' => $request->quantity ?? 1]);
            return response()->json(['message' => 'Success Create Item Cart', 'cart' => $this->cart()], 200);
        } else {
            $cart->update(['quantity' => $request->quantity ?? $cart->quantity + 1]);
            return response()->json(['message' => 'Success Update Your Cart', 'cart' => $this->cart()], 200);
        }
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $cart->delete();

        return response()->json(['message' => 'Success Delete Item In Cart', 'cart' => $this->cart()], 200);
    }

    public function clear()
    {
        Cart::clear();
        return response()->json(['message' => 'Success Clear Cart', 'cart' => $this->cart()], 200);
    }
}
