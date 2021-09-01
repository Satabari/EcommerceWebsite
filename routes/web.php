<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\CouponController;

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\frontend\CartController;

use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\user\CartPageController;

use Laravel\Jetstream\Rules\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=> 'admin', 'middleware'=>['admin:admin']], function(){
    Route::get('/login', [AdminController::class, 'loginForm']);
    Route::post('/login',[AdminController::class, 'store'])->name('admin.login');
});

//Admin Middleware

Route::middleware(['auth:admin'])->group(function(){

    Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
        return view('admin.index');
    })->name('dashboard')->middleware('auth:admin');

    //All routes of admin

    Route::get('/admin/logout',[AdminController::class, 'destroy'])->name('admin.logout');
    Route::get('/admin/profile',[AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
    Route::get('/admin/profile/edit',[AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
    Route::post('/admin/profile/store',[AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password',[AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/update/change/password',[AdminProfileController::class, 'AdminUpdateChangePassword'])->name('update.change.password');

});

//End Middleware admin

//Routes for user

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
	$id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard',compact('user'));
})->name('dashboard');

Route::get('/', [IndexController::class, 'index']);
Route::get('/user/logout',[IndexController::class, 'UserLogout'])->name('user.logout');
Route::get('/user/profile',[IndexController::class, 'UserProfile'])->name('user.profile');
Route::post('/user/profile/store',[IndexController::class, 'UserProfileStore'])->name('user.profile.store');
Route::get('/user/change/password',[IndexController::class, 'UserChangePassword'])->name('change.password');
Route::post('/user/password/update',[IndexController::class, 'UserPasswordUpdate'])->name('user.password.update');

//All routes for Admin Brands

Route::prefix('brand')->group(function(){
    Route::get('/view',[BrandController::class, 'BrandView'])->name('all.brand');
    Route::post('/store',[BrandController::class, 'BrandStore'])->name('brand.store');
    Route::get('/edit/{id}',[BrandController::class, 'BrandEdit'])->name('brand.edit');
    Route::post('/update',[BrandController::class, 'BrandUpdate'])->name('brand.update');
    Route::get('/delete/{id}',[BrandController::class, 'BrandDelete'])->name('brand.delete');
});

//All routes with Category Prefix

Route::prefix('category')->group(function(){
    
    //All routes for Admin Category

    Route::get('/view',[CategoryController::class, 'CategoryView'])->name('all.category');
    Route::post('/store',[CategoryController::class, 'CategoryStore'])->name('category.store');
    Route::get('/edit/{id}',[CategoryController::class, 'CategoryEdit'])->name('category.edit');
    Route::post('/update',[CategoryController::class, 'CategoryUpdate'])->name('category.update');
    Route::get('/delete/{id}',[CategoryController::class, 'CategoryDelete'])->name('category.delete');
    
    //All routes for Admin Sub Category
    
    Route::get('/sub/view',[SubCategoryController::class, 'SubCategoryView'])->name('all.subcategory');
    Route::post('/sub/store',[SubCategoryController::class, 'SubCategoryStore'])->name('subcategory.store');
    Route::get('/sub/edit/{id}',[SubCategoryController::class, 'SubCategoryEdit'])->name('subcategory.edit');
    Route::post('/sub/update',[SubCategoryController::class, 'SubCategoryUpdate'])->name('subcategory.update');
    Route::get('/sub/delete/{id}',[SubCategoryController::class, 'SubCategoryDelete'])->name('subcategory.delete');

    //All routes for Admin Sub->Sub Category

    Route::get('/sub/sub/view',[SubCategoryController::class, 'SubSubCategoryView'])->name('all.subsubcategory');
    Route::get('/subcategory/ajax/{category_id}',[SubCategoryController::class, 'GetSubCategory']);
    Route::get('/sub-subcategory/ajax/{subcategory_id}',[SubCategoryController::class, 'GetSubSubCategory']);
    Route::post('/sub/sub/store',[SubCategoryController::class, 'SubSubCategoryStore'])->name('subsubcategory.store');
    Route::get('/sub/sub/edit/{id}',[SubCategoryController::class, 'SubSubCategoryEdit'])->name('subsubcategory.edit');
    Route::post('/sub/sub/update',[SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subsubcategory.update');
    Route::get('/sub/sub/delete/{id}',[SubCategoryController::class, 'SubSubCategoryDelete'])->name('subsubcategory.delete');
});

//All routes for Admin Product

Route::prefix('product')->group(function(){
    Route::get('/add',[ProductController::class, 'AddProduct'])->name('add-product');
    Route::post('/store',[ProductController::class, 'StoreProduct'])->name('product-store');
    Route::get('/manage',[ProductController::class, 'ManageProduct'])->name('manage-product');
    Route::get('/details/{id}',[ProductController::class, 'ProductDetails'])->name('product.details');
    Route::get('/edit/{id}',[ProductController::class, 'ProductEdit'])->name('product.edit');
    Route::post('/update',[ProductController::class, 'ProductDataUpdate'])->name('product-update');
    Route::post('/thumbnail/update',[ProductController::class, 'ThumbnailImageUpdate'])->name('update-product-thumbnail');
    Route::post('/image/update',[ProductController::class, 'MultiImageUpdate'])->name('update-product-image');
    Route::get('/delete/{id}',[ProductController::class, 'ProductDelete'])->name('product.delete');
    Route::get('/multiimage/delete/{id}',[ProductController::class, 'ProductMultiImageDelete'])->name('product.multiimage.delete');
    Route::get('/inactive/{id}', [ProductController::class, 'ProductInactive'])->name('product.inactive');
    Route::get('/active/{id}', [ProductController::class, 'ProductActive'])->name('product.active');
});

//All routes for Admin Slider

Route::prefix('slider')->group(function(){
    Route::get('/view',[SliderController::class, 'SliderView'])->name('manage-slider');
    Route::get('/inactive/{id}', [SliderController::class, 'SliderInactive'])->name('slider.inactive');
    Route::get('/active/{id}', [SliderController::class, 'SliderActive'])->name('slider.active');
    Route::post('/store',[SliderController::class, 'SliderStore'])->name('slider.store');
    Route::get('/edit/{id}',[SliderController::class, 'SliderEdit'])->name('slider.edit');
    Route::post('/update',[SliderController::class, 'SliderUpdate'])->name('slider.update');
    Route::get('/delete/{id}',[SliderController::class, 'SliderDelete'])->name('slider.delete');
});

// Frontend Routes

//Multi-language
Route::get('/language/english',[LanguageController::class, 'English'])->name('english.language');
Route::get('/language/bengali',[LanguageController::class, 'Bengali'])->name('bengali.language');

//Product 
Route::get('/product/details/{id}/{slug}',[IndexController::class, 'ProductDetails']);

//Common Tag
Route::get('/product/tag/{tag}',[IndexController::class, 'TagWiseProduct']);

//Subcategory wise data
Route::get('/subcategory/product/{subcat_id}/{slug}', [IndexController::class, 'SubCatWiseProduct']);

//Subsubcategory wise data
Route::get('/subsubcategory/product/{subsubcat_id}/{slug}', [IndexController::class, 'SubSubCatWiseProduct']);

// Product View Modal with Ajax
Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']); 

// Add to Cart Store Data
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
// Get Data from mini cart
Route::get('/product/mini/cart/', [CartController::class, 'AddMiniCart']);
// Remove mini cart
Route::get('/minicart/product-remove/{rowId}', [CartController::class, 'RemoveMiniCart']);

// Add to Wishlist
Route::post('/add-to-wishlist/{product_id}', [CartController::class, 'AddToWishlist']);

Route::group(['prefix'=>'user','middleware' => ['user','auth'],'namespace'=>'User'],function(){
    // Wishlist page
    Route::get('/wishlist', [WishlistController::class, 'ViewWishlist'])->name('wishlist');
    // Get wishlist details
    Route::get('/get-wishlist-product', [WishlistController::class, 'GetWishlistProduct']);
    // Remove wishlist
    Route::get('/wishlist-remove/{id}', [WishlistController::class, 'RemoveWishlistProduct']);
});

// Cart view
Route::get('/mycart', [CartPageController::class, 'MyCart'])->name('mycart');
//get cart product
Route::get('/user/get-cart-product', [CartPageController::class, 'GetCartProduct']);
//remove from cart
Route::get('/user/cart-remove/{rowId}', [CartPageController::class, 'RemoveCartProduct']);
// Cart Increment
Route::get('/cart-increment/{rowId}', [CartPageController::class, 'CartIncrement']);
// Cart Decrement
Route::get('/cart-decrement/{rowId}', [CartPageController::class, 'CartDecrement']);

//All routes for Admin Coupons
Route::prefix('coupons')->group(function(){
    Route::get('/view', [CouponController::class, 'CouponView'])->name('manage-coupon');
    Route::post('/store', [CouponController::class, 'CouponStore'])->name('coupon.store');
    Route::get('/edit/{id}', [CouponController::class, 'CouponEdit'])->name('coupon.edit');
    Route::post('/update/{id}', [CouponController::class, 'CouponUpdate'])->name('coupon.update');
    Route::get('/delete/{id}', [CouponController::class, 'CouponDelete'])->name('coupon.delete');
});