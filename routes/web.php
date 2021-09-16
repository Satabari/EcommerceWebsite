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
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ShippingAreaController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\ReturnController;
use App\Http\Controllers\Backend\AdminUserController;

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\LanguageController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\HomeBlogController;
use App\Http\Controllers\Frontend\ShopController;

use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\user\CartPageController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\CashController;
use App\Http\Controllers\User\AllUserController;
use App\Http\Controllers\User\ReviewController;

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

Route::group(['prefix' => 'admin', 'middleware' => ['admin:admin']], function () {
  Route::get('/login', [AdminController::class, 'loginForm']);
  Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

//Admin Middleware

Route::middleware(['auth:admin'])->group(function () {

  Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
    return view('admin.index');
  })->name('dashboard')->middleware('auth:admin');

  //All routes of admin
  Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');
  Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
  Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');
  Route::post('/admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');
  Route::get('/admin/change/password', [AdminProfileController::class, 'AdminChangePassword'])->name('admin.change.password');
  Route::post('/update/change/password', [AdminProfileController::class, 'AdminUpdateChangePassword'])->name('update.change.password');
});
//End Middleware admin

//Routes for user
Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
  $id = Auth::user()->id;
  $user = User::find($id);
  return view('dashboard', compact('user'));
})->name('dashboard');

Route::get('/', [IndexController::class, 'index']);
Route::get('/user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');
Route::get('/user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');
Route::post('/user/profile/store', [IndexController::class, 'UserProfileStore'])->name('user.profile.store');
Route::get('/user/change/password', [IndexController::class, 'UserChangePassword'])->name('change.password');
Route::post('/user/password/update', [IndexController::class, 'UserPasswordUpdate'])->name('user.password.update');

//All routes for Admin Brands
Route::middleware('auth:admin')->prefix('brand')->group(function () {
  Route::get('/view', [BrandController::class, 'BrandView'])->name('all.brand');
  Route::post('/store', [BrandController::class, 'BrandStore'])->name('brand.store');
  Route::get('/edit/{id}', [BrandController::class, 'BrandEdit'])->name('brand.edit');
  Route::post('/update', [BrandController::class, 'BrandUpdate'])->name('brand.update');
  Route::get('/delete/{id}', [BrandController::class, 'BrandDelete'])->name('brand.delete');
});

//All routes with Category Prefix
Route::middleware('auth:admin')->prefix('category')->group(function () {

  //All routes for Admin Category
  Route::get('/view', [CategoryController::class, 'CategoryView'])->name('all.category');
  Route::post('/store', [CategoryController::class, 'CategoryStore'])->name('category.store');
  Route::get('/edit/{id}', [CategoryController::class, 'CategoryEdit'])->name('category.edit');
  Route::post('/update', [CategoryController::class, 'CategoryUpdate'])->name('category.update');
  Route::get('/delete/{id}', [CategoryController::class, 'CategoryDelete'])->name('category.delete');

  //All routes for Admin Sub Category    
  Route::get('/sub/view', [SubCategoryController::class, 'SubCategoryView'])->name('all.subcategory');
  Route::post('/sub/store', [SubCategoryController::class, 'SubCategoryStore'])->name('subcategory.store');
  Route::get('/sub/edit/{id}', [SubCategoryController::class, 'SubCategoryEdit'])->name('subcategory.edit');
  Route::post('/sub/update', [SubCategoryController::class, 'SubCategoryUpdate'])->name('subcategory.update');
  Route::get('/sub/delete/{id}', [SubCategoryController::class, 'SubCategoryDelete'])->name('subcategory.delete');

  //All routes for Admin Sub->Sub Category
  Route::get('/sub/sub/view', [SubCategoryController::class, 'SubSubCategoryView'])->name('all.subsubcategory');
  Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'GetSubCategory']);
  Route::get('/sub-subcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'GetSubSubCategory']);
  Route::post('/sub/sub/store', [SubCategoryController::class, 'SubSubCategoryStore'])->name('subsubcategory.store');
  Route::get('/sub/sub/edit/{id}', [SubCategoryController::class, 'SubSubCategoryEdit'])->name('subsubcategory.edit');
  Route::post('/sub/sub/update', [SubCategoryController::class, 'SubSubCategoryUpdate'])->name('subsubcategory.update');
  Route::get('/sub/sub/delete/{id}', [SubCategoryController::class, 'SubSubCategoryDelete'])->name('subsubcategory.delete');
});

//All routes for Admin Product
Route::middleware('auth:admin')->prefix('product')->group(function () {
  Route::get('/add', [ProductController::class, 'AddProduct'])->name('add-product');
  Route::post('/store', [ProductController::class, 'StoreProduct'])->name('product-store');
  Route::get('/manage', [ProductController::class, 'ManageProduct'])->name('manage-product');
  Route::get('/details/{id}', [ProductController::class, 'ProductDetails'])->name('product.details');
  Route::get('/edit/{id}', [ProductController::class, 'ProductEdit'])->name('product.edit');
  Route::post('/update', [ProductController::class, 'ProductDataUpdate'])->name('product-update');
  Route::post('/thumbnail/update', [ProductController::class, 'ThumbnailImageUpdate'])->name('update-product-thumbnail');
  Route::post('/image/update', [ProductController::class, 'MultiImageUpdate'])->name('update-product-image');
  Route::get('/delete/{id}', [ProductController::class, 'ProductDelete'])->name('product.delete');
  Route::get('/multiimage/delete/{id}', [ProductController::class, 'ProductMultiImageDelete'])->name('product.multiimage.delete');
  Route::get('/inactive/{id}', [ProductController::class, 'ProductInactive'])->name('product.inactive');
  Route::get('/active/{id}', [ProductController::class, 'ProductActive'])->name('product.active');
});

//All routes for Admin Slider
Route::middleware('auth:admin')->prefix('slider')->group(function () {
  Route::get('/view', [SliderController::class, 'SliderView'])->name('manage-slider');
  Route::get('/inactive/{id}', [SliderController::class, 'SliderInactive'])->name('slider.inactive');
  Route::get('/active/{id}', [SliderController::class, 'SliderActive'])->name('slider.active');
  Route::post('/store', [SliderController::class, 'SliderStore'])->name('slider.store');
  Route::get('/edit/{id}', [SliderController::class, 'SliderEdit'])->name('slider.edit');
  Route::post('/update', [SliderController::class, 'SliderUpdate'])->name('slider.update');
  Route::get('/delete/{id}', [SliderController::class, 'SliderDelete'])->name('slider.delete');
});

// Frontend Routes
//Multi-language
Route::get('/language/english', [LanguageController::class, 'English'])->name('english.language');
Route::get('/language/bengali', [LanguageController::class, 'Bengali'])->name('bengali.language');

//Product 
Route::get('/product/details/{id}/{slug}', [IndexController::class, 'ProductDetails']);
//Common Tag
Route::get('/product/tag/{tag}', [IndexController::class, 'TagWiseProduct']);
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

Route::group(['prefix' => 'user', 'middleware' => ['user', 'auth'], 'namespace' => 'User'], function () {
  // Wishlist page
  Route::get('/wishlist', [WishlistController::class, 'ViewWishlist'])->name('wishlist');
  // Get wishlist details
  Route::get('/get-wishlist-product', [WishlistController::class, 'GetWishlistProduct']);
  // Remove wishlist
  Route::get('/wishlist-remove/{id}', [WishlistController::class, 'RemoveWishlistProduct']);
  //Payment routes
  Route::post('/stripe/order', [StripeController::class, 'StripeOrder'])->name('stripe.order');
  Route::post('/cash/order', [CashController::class, 'CashOrder'])->name('cash.order');
  //Orders routes
  Route::get('/my/orders', [AllUserController::class, 'MyOrders'])->name('my.orders');
  Route::get('/order_details/{order_id}', [AllUserController::class, 'OrderDetails']);
  Route::get('/invoice_download/{order_id}', [AllUserController::class, 'InvoiceDownload']);
  Route::post('/return/order/{order_id}', [AllUserController::class, 'ReturnOrder'])->name('return.order');
  Route::get('/return/order/list', [AllUserController::class, 'ReturnOrderList'])->name('return.order.list');
  Route::get('/cancel/orders', [AllUserController::class, 'CancelOrders'])->name('cancel.orders');
  // Order Traking Route 
  Route::post('/order/tracking', [AllUserController::class, 'OrderTracking'])->name('order.tracking');    
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
Route::middleware('auth:admin')->prefix('coupons')->group(function () {
  Route::get('/view', [CouponController::class, 'CouponView'])->name('manage-coupon');
  Route::post('/store', [CouponController::class, 'CouponStore'])->name('coupon.store');
  Route::get('/edit/{id}', [CouponController::class, 'CouponEdit'])->name('coupon.edit');
  Route::post('/update/{id}', [CouponController::class, 'CouponUpdate'])->name('coupon.update');
  Route::get('/delete/{id}', [CouponController::class, 'CouponDelete'])->name('coupon.delete');
});

// Admin Shipping All Routes
Route::middleware('auth:admin')->prefix('shipping')->group(function () {

  //State routes
  Route::get('/state/view', [ShippingAreaController::class, 'StateView'])->name('manage-state');
  Route::post('/state/store', [ShippingAreaController::class, 'StateStore'])->name('state.store');
  Route::get('/state/edit/{id}', [ShippingAreaController::class, 'StateEdit'])->name('state.edit');
  Route::post('/state/update/{id}', [ShippingAreaController::class, 'StateUpdate'])->name('state.update');
  Route::get('/state/delete/{id}', [ShippingAreaController::class, 'StateDelete'])->name('state.delete');

  //District Routes
  Route::get('/district/view', [ShippingAreaController::class, 'DistrictView'])->name('manage-district');
  Route::post('/district/store', [ShippingAreaController::class, 'DistrictStore'])->name('district.store');
  Route::get('/district/edit/{id}', [ShippingAreaController::class, 'DistrictEdit'])->name('district.edit');
  Route::post('/district/update/{id}', [ShippingAreaController::class, 'DistrictUpdate'])->name('district.update');
  Route::get('/district/delete/{id}', [ShippingAreaController::class, 'DistrictDelete'])->name('district.delete');

  //City Routes
  Route::get('/city/view', [ShippingAreaController::class, 'CityView'])->name('manage-city');
  Route::post('/city/store', [ShippingAreaController::class, 'CityStore'])->name('city.store');
  Route::get('/city/edit/{id}', [ShippingAreaController::class, 'CityEdit'])->name('city.edit');
  Route::post('/city/update/{id}', [ShippingAreaController::class, 'CityUpdate'])->name('city.update');
  Route::get('/city/delete/{id}', [ShippingAreaController::class, 'CityDelete'])->name('city.delete');
});

// Frontend Coupon Option
Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);

// Checkout Routes
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');

//To get District and city according to state 
Route::get('/district-get/ajax/{state_id}', [CheckoutController::class, 'DistrictGetAjax']);
Route::get('/city-get/ajax/{district_id}', [CheckoutController::class, 'CityGetAjax']);
Route::post('/checkout/store', [CheckoutController::class, 'CheckoutStore'])->name('checkout.store');

Route::prefix('orders')->group(function () {
  Route::get('/pending/orders', [OrderController::class, 'PendingOrders'])->name('pending-orders');
  Route::get('/pending/orders/details/{order_id}', [OrderController::class, 'PendingOrdersDetails'])->name('pending.order.details');
  Route::get('/confirmed/orders', [OrderController::class, 'ConfirmedOrders'])->name('confirmed-orders');
  Route::get('/processing/orders', [OrderController::class, 'ProcessingOrders'])->name('processing-orders');
  Route::get('/picked/orders', [OrderController::class, 'PickedOrders'])->name('picked-orders');
  Route::get('/shipped/orders', [OrderController::class, 'ShippedOrders'])->name('shipped-orders');
  Route::get('/delivered/orders', [OrderController::class, 'DeliveredOrders'])->name('delivered-orders');
  Route::get('/cancel/orders', [OrderController::class, 'CancelOrders'])->name('cancel-orders');

  // Update Status 
  Route::get('/pending/confirm/{order_id}', [OrderController::class, 'PendingToConfirm'])->name('pending-confirm');
  Route::get('/confirm/processing/{order_id}', [OrderController::class, 'ConfirmToProcessing'])->name('confirm.processing');
  Route::get('/processing/picked/{order_id}', [OrderController::class, 'ProcessingToPicked'])->name('processing.picked');
  Route::get('/picked/shipped/{order_id}', [OrderController::class, 'PickedToShipped'])->name('picked.shipped');
  Route::get('/shipped/delivered/{order_id}', [OrderController::class, 'ShippedToDelivered'])->name('shipped.delivered');
  Route::get('/invoice/download/{order_id}', [OrderController::class, 'AdminInvoiceDownload'])->name('invoice.download');
});

// Admin Reports Routes 
Route::prefix('reports')->group(function () {
  Route::get('/view', [ReportController::class, 'ReportView'])->name('all-reports');
  Route::post('/search/by/date', [ReportController::class, 'ReportByDate'])->name('search-by-date');
  Route::post('/search/by/month', [ReportController::class, 'ReportByMonth'])->name('search-by-month');
  Route::post('/search/by/year', [ReportController::class, 'ReportByYear'])->name('search-by-year');
});

Route::prefix('blog')->group(function () {
  Route::get('/category', [BlogController::class, 'BlogCategory'])->name('blog.category');
  Route::post('/store', [BlogController::class, 'BlogCategoryStore'])->name('blogcategory.store');
  Route::get('/category/edit/{id}', [BlogController::class, 'BlogCategoryEdit'])->name('blog.category.edit');
  Route::post('/update', [BlogController::class, 'BlogCategoryUpdate'])->name('blogcategory.update');
  Route::get('/delete/{id}', [BlogController::class, 'BlogCategoryDelete'])->name('blogcategory.delete');

  // Admin View Blog Post Routes
  Route::get('/list/post', [BlogController::class, 'ListBlogPost'])->name('list.post');
  Route::get('/add/post', [BlogController::class, 'AddBlogPost'])->name('add.post');
  Route::post('/post/store', [BlogController::class, 'BlogPostStore'])->name('post-store');
  Route::get('/post/edit/{id}', [BlogController::class, 'BlogPostEdit'])->name('post-edit');
  Route::post('/post/update', [BlogController::class, 'BlogPostUpdate'])->name('post-update');
  Route::get('/post/delete/{id}', [BlogController::class, 'BlogPostDelete'])->name('post-delete');
});

Route::prefix('alluser')->group(function () {
  Route::get('/view', [AdminProfileController::class, 'AllUsers'])->name('all-users');
});

//  Frontend Blog Show Routes 
Route::get('/blog', [HomeBlogController::class, 'AddBlogPost'])->name('home.blog');
Route::get('/post/details/{id}', [HomeBlogController::class, 'DetailsBlogPost'])->name('post.details');
Route::get('/blog/category/post/{category_id}', [HomeBlogController::class, 'HomeBlogCatPost']);

// Admin Site Setting Routes 
Route::prefix('setting')->group(function () {
  Route::get('/site', [SiteSettingController::class, 'SiteSetting'])->name('site.setting');
  Route::post('/site/update', [SiteSettingController::class, 'SiteSettingUpdate'])->name('update.sitesetting');
  Route::get('/seo', [SiteSettingController::class, 'SeoSetting'])->name('seo.setting');
  Route::post('/seo/update', [SiteSettingController::class, 'SeoSettingUpdate'])->name('update.seosetting');
});

// Admin Return Order Routes 
Route::prefix('return')->group(function () {
  Route::get('/admin/request', [ReturnController::class, 'ReturnRequest'])->name('return.request');
  Route::get('/admin/return/approve/{order_id}', [ReturnController::class, 'ReturnRequestApprove'])->name('return.approve');
  Route::get('/admin/all/request', [ReturnController::class, 'ReturnAllRequest'])->name('all.request');
});

// Frontend Product Review Routes
Route::post('/review/store', [ReviewController::class, 'ReviewStore'])->name('review.store');

// Admin Manage Review Routes 
Route::prefix('review')->group(function () {
  Route::get('/pending', [ReviewController::class, 'PendingReview'])->name('pending.review');
  Route::get('/admin/approve/{id}', [ReviewController::class, 'ReviewApprove'])->name('review.approve');
  Route::get('/publish', [ReviewController::class, 'PublishReview'])->name('publish.review');
  Route::get('/delete/{id}', [ReviewController::class, 'DeleteReview'])->name('delete.review');
});

// Admin Manage Review Routes 
Route::prefix('stock')->group(function () {
  Route::get('/product', [ProductController::class, 'ProductStock'])->name('product.stock');
});

// Admin User Role Routes 
Route::prefix('adminuserrole')->group(function () {
  Route::get('/all', [AdminUserController::class, 'AllAdminRole'])->name('all.admin.user');
  Route::get('/add', [AdminUserController::class, 'AddAdminRole'])->name('add.admin');
  Route::post('/store', [AdminUserController::class, 'StoreAdminRole'])->name('admin.user.store');
  Route::get('/edit/{id}', [AdminUserController::class, 'EditAdminRole'])->name('edit.admin.user');
  Route::post('/update', [AdminUserController::class, 'UpdateAdminRole'])->name('admin.user.update');
  Route::get('/delete/{id}', [AdminUserController::class, 'DeleteAdminRole'])->name('delete.admin.user');
});

// Product Search Route 
Route::post('/search', [IndexController::class, 'ProductSearch'])->name('product.search');
// Advance Search Routes 
Route::post('search-product', [IndexController::class, 'SearchProduct']);
// Shop Page Route 
Route::get('/shop', [ShopController::class, 'ShopPage'])->name('shop.page');
Route::post('/shop/filter', [ShopController::class, 'ShopFilter'])->name('shop.filter');