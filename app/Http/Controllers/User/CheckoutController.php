<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;

use App\Models\ShipDistrict;
use App\Models\ShipCity;

class CheckoutController extends Controller
{
  public function DistrictGetAjax($state_id)
  {
    $ship = ShipDistrict::where('state_id', $state_id)->orderBy('district_name', 'ASC')->get();
    return json_encode($ship);
  }

  public function CityGetAjax($district_id)
  {
    $ship = ShipCity::where('district_id', $district_id)->orderBy('city_name', 'ASC')->get();
    return json_encode($ship);
  }

  public function CheckoutStore(Request $request)
  {
    // dd($request->all());
    $data = array();
    $data['shipping_name'] = $request->shipping_name;
    $data['shipping_email'] = $request->shipping_email;
    $data['shipping_phone'] = $request->shipping_phone;
    $data['post_code'] = $request->post_code;
    $data['state_id'] = $request->state_id;
    $data['district_id'] = $request->district_id;
    $data['city_id'] = $request->city_id;
    $data['notes'] = $request->notes;
    $cartTotal = Cart::total();

    if ($request->payment_method == 'stripe') {
      return view('frontend.payment.stripe',compact('data','cartTotal'));
    } elseif ($request->payment_method == 'card') {
      return 'card';
    } else {
      return view('frontend.payment.cash',compact('data','cartTotal'));
    }
  }
}
