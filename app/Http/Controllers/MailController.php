<?php

namespace App\Http\Controllers;

use App\Models\CategoryPostModel;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Silder;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Mail;
use Str;

class MailController extends Controller
{
    public function send_coupon($coupon_time,$coupon_condition,$coupon_number,$coupon_code) {
        

        $customer_vip = Customer::where('customer_vip',1)->get();
        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Mã khuyến mãi ngày".' '.$now;

        $data = [];
        foreach($customer_vip as $vip) {
            $data['email'][] = $vip->customer_email;
        }
        $coupon = array(
            'start_coupon' =>$start_coupon,
            'end_coupon' =>$end_coupon,
            'coupon_condition' =>$coupon_condition,
            'coupon_time' =>$coupon_time,
            'coupon_number' =>$coupon_number,
            'coupon_code' =>$coupon_code,
        );

        Mail::send('pages.send_coupon',['coupon'=>$coupon],function($message) use ($title_mail,$data) {
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });

        return redirect()->back()->with('message','Gửi mã khuyến mãi thành công cho khách qua email');
    }

    

    public function send_coupon_default($coupon_time,$coupon_condition,$coupon_number,$coupon_code) {
        

        $customer = Customer::where('customer_vip','=',NULL)->get();
        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Mã khuyến mãi ngày".' '.$now;

        $data = [];
        foreach($customer as $cus) {
            $data['email'][] = $cus->customer_email;
        }
        $coupon = array(
            'start_coupon' =>$start_coupon,
            'end_coupon' =>$end_coupon,
            'coupon_condition' =>$coupon_condition,
            'coupon_time' =>$coupon_time,
            'coupon_number' =>$coupon_number,
            'coupon_code' =>$coupon_code,
        );

        Mail::send('pages.send_coupon_default',['coupon'=>$coupon],function($message) use ($title_mail,$data) {
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });

        return redirect()->back()->with('message','Gửi mã khuyến mãi thành công cho khách thường qua email');
    }

    public function quen_mat_khau(Request $request) {
        $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_parent","desc")->orderBy("category_order","desc")->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();
        $meta_desc = 'Chuyên bán điện thoai chính hãng giá rẻ chất lượng';
        $meta_keywords = 'Điện thoại iphone chính hãng';
        $meta_title = "Điện thoại xịn";
        $url_canonical = $request->url();
        return view('pages.checkout.forget_pass')
        ->with('category_post',$category_post)
        ->with('slider',$slider)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('cate_product',$cate_product)
        ->with('brand_product',$brand_product)
        ;
    }

        public function recover_pass(Request $request){
            $data = $request->all();
            
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
            $title_mail = "Lấy lại mật khẩu".' '.$now;
            $customer = Customer::where('customer_email','=',$data['email_account'])->get();
            
            foreach($customer as $key => $value){
                $customer_id = $value->customer_id;
            }
            if($customer) {
                $count_customer = $customer->count();
            if($count_customer==0) {
                return redirect()->back()->with('error','Email không tồn tại');
            }else {
                $token_random = Str::random();
                $customer = Customer::find($customer_id);
                $customer->customer_token = $token_random;
                $customer->save();

                $to_email = $data['email_account'];
                $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$token_random);

                $data = array("name"=>$title_mail,"body"=>$link_reset_pass,'email'=>$data['email_account']);

                Mail::send('pages.checkout.forget_pass_notify',['data'=>$data],function($message) use ($title_mail,$data) {
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'],$title_mail);
                });

                return redirect()->back()->with('message', 'Gửi email khôi phục mật khẩu thành công')
            ;
            }
            }
        }

        public function reset_new_pass(Request $request) {
            $data = $request->all();
            $token_random = Str::random();
            $customer = Customer::where('customer_email','=',$data['email'])->where('customer_token','=',$data['token'])->get();
            $count = $customer->count();
            if($count>0) {
                foreach($customer as $key => $cus){
                    $customer_id = $cus->customer_id;
                }
                $reset = Customer::find($customer_id);
                $reset->customer_password = md5($data['password_account']);
                $reset->customer_token = $token_random;
                $reset->save();
                return redirect()->back()->with('success','Mật khẩu cập nhật thành công');
            }else {
                return redirect()->back()->with('error','Vui lòng thử lại');
            }
        }

        public function update_new_pass(Request $request){
         $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_parent","desc")->orderBy("category_order","desc")->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();
        $meta_desc = 'Chuyên bán điện thoai chính hãng giá rẻ chất lượng';
        $meta_keywords = 'Điện thoại iphone chính hãng';
        $meta_title = "Điện thoại xịn";
        $url_canonical = $request->url();
        return view('pages.checkout.new_pass')
        ->with('category_post',$category_post)
        ->with('slider',$slider)
        ->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)
        ->with('cate_product',$cate_product)
        ->with('brand_product',$brand_product)
        ;
        }
}
