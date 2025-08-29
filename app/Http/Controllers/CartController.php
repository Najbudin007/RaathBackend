<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display user's cart.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $cart = $user->cart()->with(['cartItems.product'])->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart retrieved successfully',
            'data' => [
                'cart' => $cart,
                'items' => $cart->cartItems,
                'total' => $cart->total,
            ],
        ]);
    }

    /**
     * Add item to cart.
     */
    public function addToCart(AddToCartRequest $request): JsonResponse
    {
        $user = $request->user();
        $cart = $user->cart()->first();

        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        $product = Product::findOrFail($request->product_id);

        // Check if product already exists in cart
        $existingItem = $cart->cartItems()
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->sale_price ?? $product->price,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully',
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function updateItem(Request $request, CartItem $cartItem): JsonResponse
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Cart item updated successfully',
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(Request $request, CartItem $cartItem): JsonResponse
    {
        if ($cartItem->cart->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart successfully',
        ]);
    }

    /**
     * Clear cart.
     */
    public function clear(Request $request): JsonResponse
    {
        $cart = $request->user()->cart;
        
        if ($cart) {
            $cart->cartItems()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
        ]);
    }
}
