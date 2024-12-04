<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Redirect;
session_start();


class HomeController extends Controller
{
    public function send_mail() {
        $to_name = "accc.com";
        $to_email = "checkson277@gmail.com";

        $data = array("name"=>"Mail từ tài khoản đến khách hàng","body"=>"Mail gửi về vấn đề hàng hóa");

        Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email) {
            $message->to($to_email)->subject('Quên mật khẩu');
            $message->from($to_email,$to_name);
        });
        redirect('/')->with('message','');
    }
    public function index(Request $request) {
        $meta_desc = 'Chuyên bán điện thoai chính hãng giá rẻ chất lượng';
        $meta_keywords = 'Điện thoại iphone chính hãng';
        $meta_title = "Điện thoại xịn";
        $url_canonical = $request->url();

        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();

        // $all_product = DB::table("tbl_product")
        // ->join("tbl_category_product","tbl_category_product.category_id","=","tbl_product.category_id")
        // ->join("tbl_brand","tbl_brand.brand_id","=","tbl_product.brand_id")
        // ->orderby('product_id','desc')->get();

        $all_product = DB::table("tbl_product")->where("product_status","1")->orderBy('product_id','desc')->limit(4)->get();
        // return view("pages.home")->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product);

        return view("pages.home")->with(compact('cate_product','brand_product','all_product','meta_desc','meta_keywords','url_canonical','meta_title'));
    }

    public function search(Request $request) { 
        $meta_desc = 'Tìm kiếm sản phẩm';
        $meta_keywords = 'Tìm kiếm sản phẩm';
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();

        $keywords = $request->keywords_submit;

        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();

        $search_product = DB::table("tbl_product")->where("product_name", 'like', '%' . $keywords . '%')->limit(4)->get();

        return view("pages.sanpham.search")->with('cate_product',$cate_product)->with('brand_product',$brand_product)->with('search_product',$search_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
}
