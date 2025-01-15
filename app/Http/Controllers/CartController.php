<?php

namespace App\Http\Controllers;

use App\Models\CategoryPostModel;
use App\Models\Coupon;
use App\Models\Icon;
use App\Models\Product;
use App\Models\Silder;
use Carbon\Carbon;
use DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function gio_hang(Request $request) {
        $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $meta_desc = 'Giỏ hàng của bạn';
        $meta_keywords = 'Giỏ hàng ajax';
        $meta_title = "Giỏ hàng ajax";
        $url_canonical = $request->url();
        $cate_product = DB::table("tbl_category_product")->orderBy("category_id","desc")->get(); 
        $brand_product = DB::table("tbl_brand")->orderBy("brand_id","desc")->get();

        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        
        $max_price_range = $max_price ;
       
        
        $icons = Icon::orderBy('id_icons','DESC')->get();

        return view('pages.cart.cart_ajax')->with('cate_product',$cate_product)->with('brand_product',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category_post',$category_post)
        ->with('min_price',$min_price)
        ->with('max_price',$max_price)
        ->with('max_price_range',$max_price_range)
        ->with('icons',$icons)
        ;

    }
    public function add_cart_ajax(Request $request){
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                'product_quantity' => $data['cart_product_quantity'],

            );
            Session::put('cart',$cart);
        }
       
        Session::save();

    }  

    public function del_product($session_id) {
        $cart = Session::get('cart');
        if ($cart==true) {
           foreach($cart as $key => $val) {
            if($val['session_id']==$session_id){
                unset($cart[$key]);
            }
           }
           Session::put('cart',$cart);
           return redirect()->back()->with('message','Xóa sản phẩm thành công');
        }
        else {
            return redirect()->back()->with('message','Xóa sản phẩm thất bại');
        }
    }


    public function save_cart(Request $request) {
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table("tbl_product")->where('product_id',$productId)->first();

        
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        Cart::setGlobalTax(0);
        
        return Redirect::to('gio-hang');
        // Cart::destroy();

    }
    public function show_cart(Request $request) {
        $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $meta_desc = 'Giỏ hàng của bạn';
        $meta_keywords = 'Giỏ hàng';
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();

        $cate_product = DB::table("tbl_category_product")->orderBy("category_id","desc")->get(); 
        $brand_product = DB::table("tbl_brand")->orderBy("brand_id","desc")->get();
       

        return view('pages.cart.show_cart')->with('cate_product',$cate_product)
        ->with('brand_product',$brand_product)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)->with('slider',$slider)
        ->with('category_post',$category_post)
        ;
    }

    public function delete_to_cart($rowId) { 
        Cart::update($rowId,0);

        return Redirect::to('show-cart');
    }

    public function update_cart_quantity(Request $request) { 
       $rowId = $request->rowId_cart;
       $qty = $request->cart_quantity;

       Cart::update($rowId,$qty);

        return Redirect::to('show-cart');
    }

    public function update_cart(Request $request) {
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            $message = '';
            foreach($data['cart_qty'] as $key => $qty) {
                $i = 0;
                foreach($cart as $session => $val) {
                    $i++;
                    if($val['session_id']==$key && $qty<$cart[$session]['product_quantity']) {
                        $cart[$session]['product_qty'] = $qty;
                        $message.= '<p style="color:blue">'.$i.')Cập nhật số lượng : '.$cart[$session]['product_name']. ' thành công</p>';
                    } elseif($val['session_id']==$key && $qty>$cart[$session]['product_quantity']){
                        $message.= '<p style="color:red">'.$i.')Cập nhật số lượng : '.$cart[$session]['product_name']. ' thất bại</p>';
                    }
                }
            }
            Session::put('cart',$cart);
           return redirect()->back()->with('message',$message);
        }
        else {
            return redirect()->back()->with('message','Cập nhật số lượng thất bại');
        }
    }
    
    public function del_all_product() {
        $cart = Session::get('cart');
        if($cart==true){
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('message','Xóa tất sản phẩm thành công');
        }
    }

    public function check_coupon(Request $request) {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');
        $data = $request->all();
        if (Session::get('customer_id')) {
            $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status',1)->where('coupon_date_end','>='
            ,$today)->where('coupon_used','LIKE','%'.Session::get('customer_id').'$')->first();
            if ($coupon) {
                return redirect()->back()->with('error','Mã giảm giá đã sử dụng');
            } else {
                $coupon_login = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status',1)->where('coupon_date_end','>=',$today)->first();
                if ($coupon_login) {
                    $coupon_count = $coupon_login->count();
                    if ($coupon_count>0) {
                        $coupon_session = Session::get('coupon');
                        if ($coupon_session==true) {
                            $is_avaiable = 0;
                            if ($is_avaiable==0) {
                                $cou[] = array(
                                    'coupon_code'=> $coupon_login->coupon_code,
                                    'coupon_condition'=> $coupon_login->coupon_condition,
                                    'coupon_number'=> $coupon_login->coupon_number,
                                );
                                Session::put('coupon',$cou);
                            }
                        }
                            else {
                                $cou[] = array(
                                    'coupon_code'=> $coupon_login->coupon_code,
                                    'coupon_condition'=> $coupon_login->coupon_condition,
                                    'coupon_number'=> $coupon_login->coupon_number,
                                );
                                Session::put('coupon',$cou);
                            }
                            Session::save();
                            return redirect()->back()->with('message','Thêm mã giảm giá thành công');
                        }
                    } else {
                            return redirect()->back()->with('error','Thêm mã giảm giá thất bại');
                        }
            }
        } else {
            $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status',1)->where('coupon_date_end','>=',$today)->first();
            if ($coupon) {
                $coupon_count = $coupon->count();
                if ($coupon_count>0) {
                    $coupon_session = Session::get('coupon');
                    if ($coupon_session==true) {
                        $is_avaiable = 0;
                        if ($is_avaiable==0) {
                            $cou[] = array(
                                'coupon_code'=> $coupon->coupon_code,
                                'coupon_condition'=> $coupon->coupon_condition,
                                'coupon_number'=> $coupon->coupon_number,
                            );
                            Session::put('coupon',$cou);
                        }
                    }
                        else {
                            $cou[] = array(
                                'coupon_code'=> $coupon->coupon_code,
                                'coupon_condition'=> $coupon->coupon_condition,
                                'coupon_number'=> $coupon->coupon_number,
                            );
                            Session::put('coupon',$cou);
                        }
                        Session::save();
                        return redirect()->back()->with('message','Thêm mã giảm giá thành công');
                    }
                } else {
                        return redirect()->back()->with('error','Thêm mã giảm giá thất bại');
                    }
        }
      
            }
        
    
    public function show_cart_manage() {
        $cart = count(Session::get('cart'));
        $output = '';
       if ($cart>0) {
        $output .= '<li><a href="'.url('/gio-hang').'"><i class="fa fa-shopping-cart"></i> Giỏ hàng
							<span style="background:red;border-radius:37%;padding:5px" class="badges">'.$cart.'</span></a></li>';
       } else {
        $output .= '<li><a href="'.url('/gio-hang').'"><i class="fa fa-shopping-cart"></i> Giỏ hàng
        <span style="background:red;border-radius:37%;padding:5px" class="badges">0</span></a></li>';
        
       }
       echo $output;
       
    }
   
}
