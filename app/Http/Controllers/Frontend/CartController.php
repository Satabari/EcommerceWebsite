<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Wishlist;

use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;


class CartController extends Controller
{
	public function AddToCart(Request $request, $id)
	{

		$product = Product::findOrFail($id);

		if ($product->discount_price == NULL) {
			Cart::add([
				'id' => $id,
				'name' => $request->product_name,
				'qty' => $request->quantity,
				'price' => $product->selling_price,
				'weight' => 1,
				'options' => [
					'image' => $product->product_thumbnail,
					'color' => $request->color,
					// 'size' => $request->size,
					'size' => "large",
				],
			]);

			return response()->json(['success' => 'Successfully Added on Your Cart']);
		} else {

			Cart::add([
				'id' => $id,
				'name' => $request->product_name,
				'qty' => $request->quantity,
				'price' => $product->discount_price,
				'weight' => 1,
				'options' => [
					'image' => $product->product_thumbnail,
					'color' => $request->color,
					// 'size' => $request->size,
					'size' => "large",
				],
			]);
			return response()->json(['success' => 'Successfully Added on Your Cart']);
		}
	}

	public function AddMiniCart()
	{

		$carts = Cart::content();
		$cartQty = Cart::count();
		$cartTotal = Cart::total();

		return response()->json(array(
			'carts' => $carts,
			'cartQty' => $cartQty,
			// 'cartTotal' => round($cartTotal),
			'cartTotal' => $cartTotal,
		));
	}

	/// remove mini cart 
	public function RemoveMiniCart($rowId)
	{
		Cart::remove($rowId);
		return response()->json(['success' => 'Product Remove from Cart']);
	}

	public function AddToWishlist(Request $request, $product_id)
	{
		if (Auth::check()) {
			$exists = Wishlist::where('user_id', Auth::id())->where('product_id', $product_id)->first();
			if (!$exists) {
				Wishlist::insert([
					'user_id' => Auth::id(),
					'product_id' => $product_id,
					'created_at' => Carbon::now(),
				]);
				return response()->json(['success' => 'Successfully Added On Your Wishlist']);
			}
			else{
				return response()->json(['error' => 'This Product has Already on Your Wishlist']);
			}
		}
		else {
			return response()->json(['error' => 'At first login to your account']);
		}
	}

}
