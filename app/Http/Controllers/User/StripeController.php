<?php

namespace App\Http\Controllers\User;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Mail\OrderMail;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderItem;

class StripeController extends Controller
{
  public function StripeOrder(Request $request)
  {
    if (Session::has('coupon')) {
      $total_amount = Session::get('coupon')['total_amount'];
    } else {
      $total_amount = round((float)Cart::total());
    }

    \Stripe\Stripe::setApiKey('sk_test_51JWfVYSFFRG4euR6cNqbNdf51pDODtEoNyU8wYrnOmgNzl32PtSvyLMBuLPNHLxIkv7mroxpHxDVEfZlsl5ZmFjx00fLM38X1S');
    $token = $_POST['stripeToken'];

    $charge = \Stripe\Charge::create([
      'amount' => $total_amount * 10000,
      'currency' => 'INR',
      'description' => 'Easy online shop',
      'source' => $token,
      'metadata' => ['order_id' => uniqid()],
    ]);

    // dd($charge);

    $order_id = Order::insertGetId([
      'user_id' => Auth::id(),
      'state_id' => $request->state_id,
      'district_id' => $request->district_id,
      'city_id' => $request->city_id,
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'post_code' => $request->post_code,
      'notes' => $request->notes,
      'payment_type' => 'Stripe',
      'payment_method' => 'Stripe',
      'payment_type' => $charge->payment_method,
      'transaction_id' => $charge->balance_transaction,
      'currency' => $charge->currency,
      'amount' => $total_amount,
      'order_number' => $charge->metadata->order_id,
      'invoice_no' => 'EOS' . mt_rand(10000000, 99999999),
      'order_date' => Carbon::now()->format('d F Y'),
      'order_month' => Carbon::now()->format('F'),
      'order_year' => Carbon::now()->format('Y'),
      'status' => 'pending',
      'created_at' => Carbon::now(),
    ]);

    $invoice = Order::findOrFail($order_id);
    $data = [
      'invoice_no' => $invoice->invoice_no,
      'amount' => $total_amount,
      'name' => $invoice->name,
      'email' => $invoice->email,
    ];
    Mail::to($request->email)->send(new OrderMail($data));

    $carts = Cart::content();
    foreach ($carts as $cart) {
      OrderItem::insert([
        'order_id' => $order_id,
        'product_id' => $cart->id,
        'color' => $cart->options->color,
        'size' => $cart->options->size,
        'qty' => $cart->qty,
        'price' => $cart->price,
        'created_at' => Carbon::now(),
      ]);
    }

    if (Session::has('coupon')) {
      Session::forget('coupon');
    }
    Cart::destroy();
    $notification = array(
      'message' => 'Your Order Place Successfully',
      'alert-type' => 'success'
    );

    return redirect()->route('dashboard')->with($notification);
  }
}
