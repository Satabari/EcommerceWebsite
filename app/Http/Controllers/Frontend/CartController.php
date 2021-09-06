<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Coupon;

use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;


class CartController extends Controller
{
	public function AddToCart(Request $request, $id)
	{

		if (Session::has('coupon')) {
			Session::forget('coupon');
		}
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
		$cartTotal = (float)(Cart::total());

		return response()->json(array(
			'carts' => $carts,
			'cartQty' => $cartQty,
			'cartTotal' => round($cartTotal),
			// 'cartTotal' => $cartTotal,
		));
	}

	/// remove mini cart 
	public function RemoveMiniCart($rowId)
	{
		if (Session::has('coupon')) {
			Session::forget('coupon');
		}
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
			} else {
				return response()->json(['error' => 'This Product has Already on Your Wishlist']);
			}
		} else {
			return response()->json(['error' => 'At first login to your account']);
		}
	}

	public function CouponApply(Request $request)
	{
		$coupon = Coupon::where('coupon_name', $request->coupon_name)->where('coupon_validity', '>=', Carbon::now()->format('Y-m-d'))->first();
		if ($coupon) {
			Session::put('coupon', [
				'coupon_name' => $coupon->coupon_name,
				'coupon_discount' => $coupon->coupon_discount,
				'discount_amount' => round((float)Cart::total() * $coupon->coupon_discount / 100, 2),
				'total_amount' => round((float)Cart::total() - (float)Cart::total() * $coupon->coupon_discount / 100, 2),
			]);
			return response()->json(array(
				'success' => 'Coupon Applied Successfully'
			));
		} else {
			return response()->json(['error' => 'Invalid Coupon']);
		}
	}

	public function CouponCalculation()
	{
		if (Session::has('coupon')) {
			return response()->json(array(
				'subtotal' => Cart::total(),
				'coupon_name' => session()->get('coupon')['coupon_name'],
				'coupon_discount' => session()->get('coupon')['coupon_discount'],
				'discount_amount' => session()->get('coupon')['discount_amount'],
				'total_amount' => session()->get('coupon')['total_amount'],
			));
		} else {
			return response()->json(array(
				'total' => Cart::total(),
			));
		}
	}

	public function couponRemove()
	{
		Session::forget('coupon');
		return response()->json(['success' => 'Coupon Remove Successfully']);
	}
}
