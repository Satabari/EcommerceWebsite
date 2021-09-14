<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Models\Brand;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

use App\Models\Slider;

use App\Models\Product;
use App\Models\MultiImage;
use App\Models\BlogPost;

class IndexController extends Controller
{
  public function index()
  {
    $blogpost = BlogPost::latest()->get();
    $categories = Category::orderBy('category_name', 'ASC')->get();

    $sliders = Slider::where('status', 1)->orderBy('id', 'DESC')->limit(3)->get();

    $products = Product::where('status', 1)->orderBy('id', 'DESC')->get();
    $featured = Product::where('featured', 1)->orderBy('id', 'DESC')->get();

    $skip_category_0 = Category::skip(0)->first();
    $skip_category_product_0 = Product::where('status', 1)->where('category_id', $skip_category_0->id)->orderBy('id', 'DESC')->get();

    $skip_category_1 = Category::skip(1)->first();
    $skip_category_product_1 = Product::where('status', 1)->where('category_id', $skip_category_1->id)->orderBy('id', 'DESC')->get();

    $skip_brand = Brand::skip(3)->first();
    $skip_brand_product = Product::where('status', 1)->where('brand_id', $skip_brand->id)->orderBy('id', 'DESC')->get();

    return view('frontend.index', compact('categories', 'sliders', 'products', 'featured', 'skip_category_0', 'skip_category_product_0', 'skip_category_1', 'skip_category_product_1', 'skip_brand', 'skip_brand_product','blogpost'));
  }

  public function UserLogout()
  {
    Auth::logout();
    return Redirect()->route('login');
  }

  public function UserProfile()
  {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('frontend.profile.user_profile', compact('user'));
  }

  public function UserProfileStore(Request $request)
  {
    $data = User::find(Auth::user()->id);
    $data->name = $request->name;
    $data->email = $request->email;
    $data->phone = $request->phone;


    if ($request->file('profile_photo_path')) {
      $file = $request->file('profile_photo_path');
      @unlink(public_path('upload/user_images/' . $data->profile_photo_path));
      $filename = date('YmdHi') . $file->getClientOriginalName();
      $file->move(public_path('upload/user_images'), $filename);
      $data['profile_photo_path'] = $filename;
    }

    $data->save();

    $notification = array(
      'message' => 'User Profile Updated Succesfully',
      'alert-type' => 'success'
    );

    return redirect()->route('dashboard')->with($notification);
  }

  public function UserChangePassword()
  {
    return view('frontend.profile.change_password');
  }

  public function UserPasswordUpdate(Request $request)
  {
    $validateData = $request->validate([
      'oldpassword' => 'required',
      'password' => 'required|confirmed',
    ]);
    $hashedPassword = Auth::user()->password;
    if (Hash::check($request->oldpassword, $hashedPassword)) {
      $id = Auth::user()->id;
      $user = User::find($id);
      $user->password = Hash::make($request->password);
      $user->save();
      Auth::logout();
      return redirect()->route('user.logout');
    } else {
      return redirect()->back();
    }
  }

  public function ProductDetails($id, $slug)
  {
    $product = Product::findOrFail($id);

    $color = $product->product_color;
    $product_color = explode(',', $color);

    $size = $product->product_size;
    $product_size = explode(',', $size);

    $multiImg = MultiImage::where('product_id', $id)->get();

    $cat_id = $product->category_id;
    $relatedProduct = Product::where('category_id', $cat_id)->where('id', '!=', $id)->orderBy('id', 'DESC')->get();

    return view('frontend.product.product_details', compact('product', 'multiImg', 'product_color', 'product_size', 'relatedProduct'));
  }

  public function TagWiseProduct($tag)
  {
    $products = Product::where('status', 1)->where('product_tag', $tag)->orderBy('id', 'DESC')->paginate(3);
    // return view('frontend.tags.tags_view',compact('products','tag'));

    $categories = Category::orderBy('category_name', 'ASC')->get();

    return view('frontend.tags.tags_view', compact('products', 'categories'));
  }

  public function SubCatWiseProduct($subcat_id, $slug)
  {
    $products = Product::where('status', 1)->where('subcategory_id', $subcat_id)->orderBy('id', 'DESC')->paginate(3);
    $categories = Category::orderBy('category_name', 'ASC')->get();
    return view('frontend.product.subcategory_view', compact('products', 'categories'));
  }

  public function SubSubCatWiseProduct($subsubcat_id, $slug)
  {
    $products = Product::where('status', 1)->where('subsubcategory_id', $subsubcat_id)->orderBy('id', 'DESC')->paginate(6);
    $categories = Category::orderBy('category_name', 'ASC')->get();
    return view('frontend.product.sub_subcategory_view', compact('products', 'categories'));
  }

  public function ProductViewAjax($id)
  {
    $product = Product::with('category', 'brand')->findOrFail($id);

    $color = $product->product_color;
    $product_color = explode(',', $color);

    $size = $product->product_size;
    $product_size = explode(',', $size);

    return response()->json(array(
      'product' => $product,
      'color' => $product_color,
      'size' => $product_size,

    ));
  }
  
}
