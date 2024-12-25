<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryPost;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

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

// Frontend
Route::get("/", [HomeController::class, 'index']);
Route::get('/trang-chu',[HomeController::class, 'index']); 
Route::post('/tim-kiem',[HomeController::class, 'search']); 
Route::post('/autocomplete-ajax',[HomeController::class, 'autocomplete_ajax']); 
Route::get('/lien-he',[ContactController::class, 'lien_he']); 
Route::post("/update-info/{info_id}", [ContactController::class, 'update_info'])->name('update-info');
Route::get("/information", [ContactController::class, 'information'])->name('information');
Route::post("/save-information", [ContactController::class, 'save_information'])->name('save-information');

// Danh mục sản phẩm trang chủ
Route::get('/danh-muc-san-pham/{slug_category_product}',[CategoryProduct::class, 'show_category_home']); 
Route::get('/thuong-hieu-san-pham/{slug_brand_product}',[BrandProduct::class, 'show_brand_home']); 
Route::get('/chi-tiet-san-pham/{slug_product}',[ProductController::class, 'details_product']); 
Route::get('/tag/{product_tag}',[ProductController::class, 'tag']); 
Route::post('/quickview',[ProductController::class, 'quickview']); 
Route::post('/load-comment',[ProductController::class, 'load_comment']); 
Route::post('/send-comment',[ProductController::class, 'send_comment']); 
Route::get('/comment',[ProductController::class, 'list_comment'])->name('list-comment'); 
Route::post('/allow-comment',[ProductController::class, 'allow_comment'])->name('allow-comment'); 
Route::post('/reply-comment',[ProductController::class, 'reply_comment'])->name('reply-comment'); 
Route::post('/insert-rating',[ProductController::class, 'insert_rating'])->name('insert-rating'); 

Route::get('/uploads-ckeditor',[ProductController::class, 'ckeditor_image'])->name('uploads-ckeditor'); 
Route::get('/file-browser',[ProductController::class, 'file_browser'])->name('file-browser'); 


// Backend
Route::get("/admin", [AdminController::class, 'index']);
Route::get("/dashboard", [AdminController::class, 'show_dashboard'])->name('dashboard');
Route::get("/logout", [AdminController::class, 'logout'])->name('logout');
Route::post("/admin-dashboard", [AdminController::class, 'dashboard']);
Route::post("/filter-by-date", [AdminController::class, 'filter_by_date']);
Route::post("/dashboard-filter", [AdminController::class, 'dashboard_filter']);
Route::post("/days-order", [AdminController::class, 'days_order']);



// Category Product
Route::get('/add-category-product', [CategoryProduct::class,'add_category_product'])->name('add-category-product')->middleware('auth.roles');
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class,'edit_category_product'])->name('edit-category-product')->middleware('auth.roles');
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class,'delete_category_product'])->name('delete-category-product')->middleware('auth.roles');
Route::get('/all-category-product', [CategoryProduct::class,'all_category_product'])->name('all-category-product')->middleware('auth.roles');

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class,'unactive_category_product'])->middleware('auth.roles');
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class,'active_category_product'])->middleware('auth.roles');

Route::get('/send-mail', [HomeController::class,'send_mail'])->name('send-mail');

Route::post('/product-tabs', [CategoryProduct::class,'product_tabs'])->name('product-tabs');

Route::post('/save-category-product', [CategoryProduct::class,'save_category_product'])->name('save-category-product')->middleware('auth.roles');
Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class,'update_category_product'])->name('update-category-product')->middleware('auth.roles');
Route::post('/arrange-category',[CategoryProduct::class, 'arrange_category'])->name('arrange-category'); 

// Brand Product
Route::get('/add-brand-product', [BrandProduct::class,'add_brand_product'])->name('add-brand-product')->middleware('auth.roles');
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class,'edit_brand_product'])->name('edit-brand-product')->middleware('auth.roles');
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class,'delete_brand_product'])->name('delete-brand-product')->middleware('auth.roles');
Route::get('/all-brand-product', [BrandProduct::class,'all_brand_product'])->name('all-brand-product')->middleware('auth.roles');

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class,'unactive_brand_product'])->middleware('auth.roles');
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class,'active_brand_product'])->middleware('auth.roles');


Route::post('/save-brand-product', [BrandProduct::class,'save_brand_product'])->name('save-brand-product')->middleware('auth.roles');
Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class,'update_brand_product'])->name('update-brand-product')->middleware('auth.roles');

// Product

Route::get('/delete-product/{product_id}', [ProductController::class,'delete_product'])->name('delete-product')->middleware('auth.roles');
Route::get('/all-product', [ProductController::class,'all_product'])->name('all-product')->middleware('auth.roles');

Route::get('/unactive-product/{product_id}', [ProductController::class,'unactive_product'])->middleware('auth.roles');
Route::get('/active-product/{product_id}', [ProductController::class,'active_product'])->middleware('auth.roles');


Route::post('/save-product', [ProductController::class,'save_product'])->name('save-product')->middleware('auth.roles');
Route::post('/update-product/{product_id}', [ProductController::class,'update_product'])->name('update-product')->middleware('auth.roles');



// Cart
Route::post('/save-cart', [CartController::class,'save_cart'])->name('save-cart');
Route::post('/update-cart-quantity', [CartController::class,'update_cart_quantity'])->name('update-cart-quantity');
Route::post('/update-cart', [CartController::class,'update_cart'])->name('update-cart');
Route::get('/show-cart', [CartController::class,'show_cart'])->name('show-cart');
Route::get('/gio-hang', [CartController::class,'gio_hang'])->name('gio-hang');
Route::get('/delete-to-cart/{rowId}', [CartController::class,'delete_to_cart'])->name('delete-to-cart');
Route::get('/del-product/{session_id}', [CartController::class,'del_product'])->name('del-product');
Route::get('/del-all-product', [CartController::class,'del_all_product'])->name('del-all-product');
Route::post('/add-cart-ajax', [CartController::class,'add_cart_ajax'])->name('add-cart-ajax');

// Coupon
Route::post('/check-coupon', [CartController::class,'check_coupon'])->name('check-coupon');
Route::get('/insert-coupon', [CouponController::class,'insert_coupon'])->name('insert-coupon')->middleware('auth.roles');
Route::get('/unset-coupon', [CouponController::class,'unset_coupon'])->name('unset-coupon');
Route::get('/delete-coupon/{coupon_id}', [CouponController::class,'delete_coupon'])->name('delete-coupon');
Route::get('/list-coupon', [CouponController::class,'list_coupon'])->name('list-coupon')->middleware('auth.roles');
Route::post('/insert-coupon-code', [CouponController::class,'insert_coupon_code'])->name('insert-coupon-code');


// Checkout
Route::get('/login-checkout', [CheckoutController::class,'login_checkout'])->name('login-checkout');
Route::get('/logout-checkout', [CheckoutController::class,'logout_checkout'])->name('logout-checkout');
Route::post('/add-customer', [CheckoutController::class,'add_customer'])->name('add-customer');
Route::post('/order-place', [CheckoutController::class,'order_place'])->name('order-place');
Route::get('/checkout', [CheckoutController::class,'checkout'])->name('checkout');
Route::get('/payment', [CheckoutController::class,'payment'])->name('payment');
Route::post('/save-checkout-customer', [CheckoutController::class,'save_checkout_customer'])->name('save-checkout-customer');
Route::post('/login-customer', [CheckoutController::class,'login_customer'])->name('login-customer');
Route::post('/select-delivery-home', [CheckoutController::class,'select_delivery_home'])->name('select-delivery-home');
Route::post('/calculate-fee', [CheckoutController::class,'calculate_fee'])->name('calculate-fee');
Route::get('/del-fee', [CheckoutController::class,'del_fee'])->name('del-fee');
Route::post('/confirm-order', [CheckoutController::class,'confirm_order'])->name('confirm-order');


// Login facebook
Route::get('/login-facebook', [AdminController::class,'login_facebook'])->name('login-facebook');
Route::get('/admin/callback', [AdminController::class,'callback_facebook'])->name('admin/callback');

Route::get('/manage-order', [OrderController::class,'manage_order'])->name('manage-order')->middleware('auth.roles');
Route::get('/view-order/{order_code}', [OrderController::class,'view_order'])->name('view-order');
Route::get('/print-order/{checkout_code}', [OrderController::class,'print_order'])->name('print-order');
Route::post('/update-order-qty', [OrderController::class,'update_order_qty'])->name('update-order-qty');
Route::post('/update-qty', [OrderController::class,'update_qty'])->name('update-qty');

//Login google
Route::get('/login-google', [AdminController::class,'login_google'])->name('login-google');
Route::get('/google/callback', [AdminController::class,'callback_google'])->name('/google/callback');

Route::get('/delivery', [DeliveryController::class,'delivery'])->name('delivery')->middleware('auth.roles');
Route::post('/select-delivery', [DeliveryController::class,'select_delivery'])->name('select-delivery');
Route::post('/insert-delivery', [DeliveryController::class,'insert_delivery'])->name('insert-delivery');
Route::post('/select-feeship', [DeliveryController::class,'select_feeship'])->name('select-feeship');
Route::post('/update-delivery', [DeliveryController::class,'update_delivery'])->name('update-delivery');

// Banner
Route::get('/manage-banner', [SliderController::class,'manage_banner'])->name('manage-banner')->middleware('auth.roles');
Route::get('/add-slider', [SliderController::class,'add_slider'])->name('add-slider')->middleware('auth.roles');
Route::post('/insert-slider', [SliderController::class,'insert_slider'])->name('insert-slider')->middleware('auth.roles');
Route::get('/unactive-slider/{slider_id}', [SliderController::class,'unactive_slider'])->middleware('auth.roles');
Route::get('/inactive-slider/{slider_id}', [SliderController::class,'inactive_slider'])->middleware('auth.roles');


Route::post('/export-csv', [CategoryProduct::class,'export_csv'])->name('export-csv');
Route::post('/import-csv', [CategoryProduct::class,'import_csv'])->name('import-csv');


Route::post('/export-csv-product', [ProductController::class,'export_csv_product'])->name('export-csv-product');
Route::post('/import-csv-product', [ProductController::class,'import_csv_product'])->name('import-csv-product');


// Authentication roles
Route::get('/register-auth', [AuthController::class,'register_auth'])->name('register-auth');
Route::post('/register', [AuthController::class,'register'])->name('register');
Route::get('/login-auth', [AuthController::class,'login_auth'])->name('login-auth');
Route::get('/logout-auth', [AuthController::class,'logout_auth'])->name('logout-auth');
Route::post('/login', [AuthController::class,'login'])->name('login');


// User Phân quyền
Route::get('/users', [UserController::class,'index'])->name('users')->middleware('auth.roles');
Route::get('/add-users', [UserController::class,'add_users'])->name('add-users')->middleware('auth.roles');
Route::get('/delete-user-roles/{admin_id}', [UserController::class,'delete_user_roles'])->name('delete-user-roles')->middleware('auth.roles');
Route::post('/assign-roles', [UserController::class,'assign_roles'])->name('assign-roles')->middleware('auth.roles');
Route::post('/store-users', [UserController::class,'store_users'])->name('store-users')->middleware('auth.roles');

Route::get('/impersonate/{admin_id}', [UserController::class,'impersonate'])->name('impersonate');
Route::get('/impersonate-destroy', [UserController::class,'impersonate_destroy'])->name('impersonate-destroy');

Route::group(['middleware' => 'auth.roles'],function(){
    Route::get('/add-product', [ProductController::class,'add_product'])->name('add-product');
    Route::get('/edit-product/{product_id}', [ProductController::class,'edit_product'])->name('edit-product');
});


// Bài viêt
Route::get('/add-category-post', [CategoryPost::class,'add_category_post'])->name('add-category-post');
Route::post('/save-category-post', [CategoryPost::class,'save_category_post'])->name('save-category-post');
Route::get('/all-category-post', [CategoryPost::class,'all_category_post'])->name('all-category-post');
Route::get('/delete-category-post/{cate_id}', [CategoryPost::class,'delete_category_post'])->name('delete-category-post');

Route::get('/edit-category-post/{category_post_id}', [CategoryPost::class,'edit_category_post'])->name('edit-category-post');
Route::post('/update-category-post/{cate_id}', [CategoryPost::class,'update_category_post'])->name('update-category-post');

Route::get('/delete-category-post/{category_post_id}', [CategoryPost::class,'delete_category_post'])->name('delete-category-post');

Route::get('/add-post', [PostController::class,'add_post'])->name('add-post');
Route::get('/all-post', [PostController::class,'all_post'])->name('all-post');
Route::post('/save-post', [PostController::class,'save_post'])->name('save-post');

Route::get('/edit-post/{post_id}', [PostController::class,'edit_post'])->name('edit-post');
Route::post('/update-post/{post_id}', [PostController::class,'update_post'])->name('update-post');
Route::get('/delete-post/{post_id}', [PostController::class,'delete_post'])->name('delete-post');


// Bai viet
Route::get('/danh-muc-bai-viet/{post_slug}',[PostController::class, 'danh_muc_bai_viet'])->name('danh-muc-bai-viet'); 
Route::get('/bai-viet/{post_slug}',[PostController::class, 'bai_viet'])->name('bai-viet'); 
Route::get('/update-post/{post_id}',[PostController::class, 'update_post'])->name('update-post'); 

// Gallery
Route::get('/add-gallery/{product_id}',[GalleryController::class, 'add_gallery'])->name('add-gallery'); 
Route::post('/select-gallery',[GalleryController::class, 'select_gallery'])->name('select-gallery'); 
Route::post('/insert-gallery/{pro_id}',[GalleryController::class, 'insert_gallery'])->name('insert-gallery'); 
Route::post('/update-gallery-name',[GalleryController::class, 'update_gallery_name'])->name('update-gallery-name'); 
Route::post('/delete-gallery',[GalleryController::class, 'delete_gallery'])->name('delete-gallery'); 
Route::post('/update-gallery',[GalleryController::class, 'update_gallery'])->name('update-gallery'); 

// Video
Route::get('/video',[VideoController::class, 'video'])->name('video'); 
Route::get('/save-video',[VideoController::class, 'save_video'])->name('save-video'); 
Route::post('/select-video',[VideoController::class, 'select_video'])->name('select-video'); 
Route::post('/insert-video',[VideoController::class, 'insert_video'])->name('insert-video'); 
Route::post('/update-video',[VideoController::class, 'update_video'])->name('update-video'); 
Route::post('/delete-video',[VideoController::class, 'delete_video'])->name('delete-video'); 
Route::get('/video-shop',[VideoController::class, 'video_shop'])->name('video-shop'); 
Route::post('/update-video-image',[VideoController::class, 'update_video_image'])->name('update-video-image'); 
Route::post('/watch-video',[VideoController::class, 'watch_video'])->name('watch-video'); 
