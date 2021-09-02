<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ShipState;
use App\Models\ShipDistrict;
use App\Models\ShipCity;

use Carbon\Carbon;

class ShippingAreaController extends Controller
{
  public function StateView()
  {
    $state = ShipState::orderBy('id', 'DESC')->get();
    return view('backend.ship.state.view_state', compact('state'));
  }

  public function StateStore(Request $request)
  {
    $request->validate([
      'state_name' => 'required',
    ]);
    ShipState::insert([
      'state_name' => $request->state_name,
      'created_at' => Carbon::now(),
    ]);
    $notification = array(
      'message' => 'State Inserted Successfully',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }

  public function StateEdit($id)
  {
    $state = ShipState::findOrFail($id);
    return view('backend.ship.state.edit_state', compact('state'));
  }

  public function StateUpdate(Request $request, $id)
  {
    ShipState::findOrFail($id)->update([
      'state_name' => $request->state_name,
      'created_at' => Carbon::now(),
    ]);
    $notification = array(
      'message' => 'State Updated Successfully',
      'alert-type' => 'info'
    );
    return redirect()->route('manage-state')->with($notification);
  }

  public function StateDelete($id)
  {
    ShipState::findOrFail($id)->delete();
    $notification = array(
      'message' => 'State Deleted Successfully',
      'alert-type' => 'info'
    );
    return redirect()->back()->with($notification);
  }

  public function DistrictView()
  {
    $state = ShipState::orderBy('state_name', 'ASC')->get();
    $district = ShipDistrict::with('state')->orderBy('id', 'DESC')->get();
    return view('backend.ship.district.view_district', compact('state', 'district'));
  }

  public function DistrictStore(Request $request)
  {
    $request->validate([
      'state_id' => 'required',
      'district_name' => 'required',
    ]);
    ShipDistrict::insert([
      'state_id' => $request->state_id,
      'district_name' => $request->district_name,
      'created_at' => Carbon::now(),
    ]);
    $notification = array(
      'message' => 'District Inserted Successfully',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }

  public function DistrictEdit($id)
  {
    $state = ShipState::orderBy('state_name', 'ASC')->get();
    $district = ShipDistrict::findOrFail($id);
    return view('backend.ship.district.edit_district', compact('district', 'state'));
  }

  public function DistrictUpdate(Request $request, $id)
  {
    ShipDistrict::findOrFail($id)->update([
      'state_id' => $request->state_id,
      'district_name' => $request->district_name,
      'created_at' => Carbon::now(),
    ]);
    $notification = array(
      'message' => 'District Updated Successfully',
      'alert-type' => 'info'
    );
    return redirect()->route('manage-district')->with($notification);
  }

  public function DistrictDelete($id)
  {
    ShipDistrict::findOrFail($id)->delete();
    $notification = array(
      'message' => 'District Deleted Successfully',
      'alert-type' => 'info'
    );
    return redirect()->back()->with($notification);
  }

  public function CityView()
  {
    $state = ShipState::orderBy('state_name', 'ASC')->get();
    $district = ShipDistrict::orderBy('district_name', 'ASC')->get();
    $city = ShipCity::orderBy('id', 'DESC')->get();
    return view('backend.ship.city.view_city', compact('state', 'district', 'city'));
  }

  public function CityStore(Request $request)
  {
    $request->validate([
      'state_id' => 'required',
      'district_id' => 'required',
      'city_name' => 'required',
    ]);
    Shipcity::insert([
      'state_id' => $request->state_id,
      'district_id' => $request->district_id,
      'city_name' => $request->city_name,
      'created_at' => Carbon::now(),
    ]);
    $notification = array(
      'message' => 'City Inserted Successfully',
      'alert-type' => 'success'
    );
    return redirect()->back()->with($notification);
  }

  public function CityEdit($id)
  {
    $state = ShipState::orderBy('state_name', 'ASC')->get();
    $district = ShipDistrict::orderBy('district_name', 'ASC')->get();
    $city = ShipCity::findOrFail($id);
    return view('backend.ship.city.edit_city', compact('state', 'district', 'city'));
  }

  public function CityUpdate(Request $request, $id)
  {
    ShipCity::findOrFail($id)->update([
      'state_id' => $request->state_id,
      'district_id' => $request->district_id,
      'city_name' => $request->city_name,
      'created_at' => Carbon::now(),
    ]);
    $notification = array(
      'message' => 'city Updated Successfully',
      'alert-type' => 'info'
    );
    return redirect()->route('manage-city')->with($notification);
  }

  public function CityDelete($id)
  {
    Shipcity::findOrFail($id)->delete();
    $notification = array(
      'message' => 'city Deleted Successfully',
      'alert-type' => 'info'
    );
    return redirect()->back()->with($notification);
  }

}
