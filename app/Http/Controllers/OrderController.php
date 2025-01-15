<?php

namespace App\Http\Controllers;

use App\Models\CategoryPostModel;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Silder;
use App\Models\Statistic;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\Shipping;
use Mail;
use PDF;
use Session;

class OrderController extends Controller
{
    public function manage_order() {
        $order = Order::orderBy('created_at','DESC')->get();
        return view('admin.manage_order')->with(compact('order'));
    }
    public function view_order($order_code) {
        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code',$order_code)->get();

      
        foreach($order_details_product as $key => $ord_d){
            $product_coupon = $ord_d->product_coupon;
        }

        if ($product_coupon != 'no') {
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        } else {
            $coupon_condition = 2;
            $coupon_number = 0;
        }

        return view('admin.view_order')->with(compact('order_details','customer','shipping','order','order_details','coupon_condition','coupon_number','order','order_status'));
    }

    public function print_order($checkout_code) {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_cover($checkout_code));
        return $pdf->stream();
    }
    public function print_order_cover($checkout_code) {
        $order_details = OrderDetails::where('order_code',$checkout_code)->get();
        $order = Order::where('order_code',$checkout_code)->get();
        foreach($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        
        $order_details_product = OrderDetails::with('product')->where('order_code',$checkout_code)->get();
        foreach($order_details_product as $key => $ord_d){
            $product_coupon = $ord_d->product_coupon;
        }

        if ($product_coupon != 'no') {
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();
           
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
            if ($coupon_condition==1) {
                $coupon_echo = $coupon_number.'%';
            }elseif($coupon_condition==2){
                $coupon_echo = number_format($coupon_number, 0, ',', '.').'đ';
            }
        } else {
            $coupon_condition = 2;
            $coupon_number = 0;
            $coupon_echo = '0';
        }


        $output = '';

        $output.='
        <style>
        body {
        font-family: DejaVu Sans;
    }
        .table-styling tbody tr td{
        border:1px solid #000;
        }

        .table-styling{
        border:1px solid #000;
        }
        </style>
        <h1><center>Công ty abc</center></h1>
        <p>Người đặt hàng</p>
        <table class="table table-styling">
        <thead>
            <tr>
            <th>Tên khác hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            </tr>
        </thead>
        <tbody>';

            $output.='
                <tr>
                <td>'.$customer->customer_name.'</td>
                <td>'.$customer->customer_phone.'</td>
                <td>'.$customer->customer_email.'</td>
                </tr>';
            $output.='
        </tbody>
        </table>
         <p>Ship hàng tới</p>
        <table class="table table-styling">
        <thead>
            <tr>
            <th>Tên người nhận</th>
            <th>Địa chỉ</th>
            <th>Sđt</th>
            <th>Email</th>
            <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>';

            $output.='
                <tr>
                <td>'.$shipping->shipping_name.'</td>
                <td>'.$shipping->shipping_address.'</td>
                <td>'.$shipping->shipping_phone.'</td>
                <td>'.$shipping->shipping_email.'</td>
                <td>'.$shipping->shipping_notes.'</td>
                </tr>';
            $output.='
        </tbody>
        </table>

        </table>
         <p>Liệt kê đơn hàng</p>
        <table class="table table-styling">
        <thead>
            <tr>
            <th>Tên sản phẩm</th>
            <th>Mã giảm giá	</th>
            <th>Số lượng</th>
            <th>Phí ship</th>
            <th>Giá sản phẩm</th>
            <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>';
        $total=0;
        
            foreach ($order_details_product as $key => $product) {
               $subtotal = $product->product_price*$product->product_sales_quantity;
               $total+=$subtotal;
               if($product->product_coupon != 'no') {
                    $product_coupon = $product->product_coupon;
               } else {
                    $product_coupon = 'không mã';
               }
                $output.='
                    <tr>
                    <td>'.$product->product_name.'</td>
                    <td>'.$product_coupon.'</td>
                    <td>'.$product->product_sales_quantity.'</td>
                    <td>'.$product->product_feeship.'</td>
                    <td>'.number_format($product->product_price, 0, ',', '.').'</td>
                     <td>'.number_format($subtotal, 0, ',', '.').'</td>
                    </tr>';
            }
            if($coupon_condition==1){
                $total_after_coupon = ($total*$coupon_number)/100;
                $total_coupon = $total - $total_after_coupon ;
            }else {
                $total_coupon = $total - $coupon_number;
            }
            $output.='
            <tr>
            <td colspan="2">
            <p>Tổng giảm : '.$coupon_echo.'</p>
            <p>Phí ship: '.number_format( $product->product_feeship, 0, ',', '.').'</p>
            <p>Thanh toán: '.number_format($total_coupon + $product->product_feeship, 0, ',', '.').'</p>
            </td>
            </tr>
            ';
            $output.='
        </tbody>
        </table>

         <p>Ký tên</p>
        <table class="">
        <thead>
            <tr>
            <th width="200px">Người lập phiếu</th>
            <th width="800px">Người nhận</th>
            </tr>
        </thead>
        <tbody>';

            $output.='
                <tr>
                </tr>';
            $output.='
        </tbody>
        </table>'
        
        ;

        return $output;
    }

    public function update_order_qty(Request $request) {
        $data = $request->all();
    
        // Tìm đơn hàng theo order_id
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();

        
        // send mail confirm

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Đơn hàng đã đặt được xác nhận".' '.$now;
        $customer = Customer::where('customer_id',$order->customer_id)->first();
        $data['email'][] = $customer->customer_email;


        foreach ($data['order_product_id'] as $key => $product) {
                $product_mail = Product::find($product);
                foreach($data['quantity'] as $key2 => $qty){
                    if ($key==$key2) {
                       $cart_array[] = array(
                        'product_name' => $product_mail['product_name'],
                        'product_price' => $product_mail['product_price'],
                        'product_qty' => $product_mail['product_qty'],
                       );
                    }
                }
        }

        $details = OrderDetails::where('order_code',$order->order_code)->first();
        $fee_ship = $details->product_feeship;
        $coupon_mail = $details->product_coupon;



        $shipping = Shipping::where('shipping_id',$order->shipping_id)->first();
        
        $shipping_array = array(
            'fee_ship' => $fee_ship,
            'customer_name' => $customer->customer_name,
            'shipping_name' => $shipping->shipping_name,
            'shipping_email' => $shipping->shipping_email,
            'shipping_phone' => $shipping->shipping_phone,
            'shipping_address' => $shipping->shipping_address,
            'shipping_notes' => $shipping->shipping_notes,
            'shipping_method' => $shipping->shipping_method,
        );

        $ordercode_mail = array(
            'coupon_code' => $coupon_mail,
            'order_code' => $details->order_code,

        );

        Mail::send('admin.confirm_order',['cart_array'=>$cart_array,'shipping_array'=>$shipping_array,'code'=>$ordercode_mail],function($message) use ($title_mail,$data) {
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });


        $order_date = $order->order_date;
        $statistic = Statistic::where('order_date',$order_date)->get();
        if ($statistic) {
           $statistic_count = $statistic->count();
        } else {
            $statistic_count = 0;
        }
        
    
        // Kiểm tra trạng thái đơn hàng đã xử lý
        if ($order->order_status == 2) {  
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $quantity = 0;
            

            foreach ($data['order_product_id'] as $key => $product_id) {
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;

                $product_price = $product->product_price;
                $price_cost = $product->price_cost;
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();    
                // Kiểm tra và cập nhật số lượng tồn kho và số lượng đã bán
    
              foreach($data['quantity'] as $key2 => $qty){
                if ($key == $key2) {
                    // Cập nhật số lượng tồn kho và số lượng đã bán
                    $pro_remain = $product_quantity - $qty;
                    $product->product_quantity = $pro_remain;  // Cập nhật kho
                    $product->product_sold = $product_sold + $qty; // Cập nhật số lượng đã bán
                    $product->save();

                    $quantity+=$qty;
                    $total_order+=1;
                    $sales+=$product_price*$qty;
                    $profit = $sales-($price_cost*$qty);
                }
              }
            }

           
            
            if ($statistic_count>0) {
                $statistic_update = Statistic::where('order_date',$order_date)->first();
                $statistic_update->sales = $statistic_update->sales + $sales;
                $statistic_update->profit = $statistic_update->profit + $profit;
                $statistic_update->quantity = $statistic_update->quantity + $quantity;
                $statistic_update->total_order = $statistic_update->total_order + $total_order;
                $statistic_update->save();
            } else {
                $statistic_new = new Statistic();
                $statistic_new->order_date = $order_date;
                $statistic_new->sales = $sales;
                $statistic_new->profit = $profit;
                $statistic_new->quantity = $quantity;
                $statistic_new->total_order = $total_order;
                $statistic_new->save();
            }
            
        } 


        
    }
    
    

    public function update_qty(Request $request) {
        $data = $request->all();
        $order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();

        $order_details->product_sales_quantity = $data['order_qty'];
        $order_details->save();

        
    }

    public function history(Request $request) {
        if (!Session::get('customer_id')) {
           return redirect('login-checkout')->with('error','Vui lòng đăng nhập để xem lịch sử đơn hàng');
        } else {
            $getorder = Order::where('customer_id',Session::get('customer_id'))->orderBy('order_id','DESC')->paginate(1);

            $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();
            $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
            $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_parent","desc")->orderBy("category_order","desc")->get();
            $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
            $meta_desc = 'Lịch sử đặt hàng';
            $meta_keywords = 'Lịch sử đặt hàng';
            $meta_title = "Lịch sử đặt hàng";
            $url_canonical = $request->url();
            return view('pages.history.history')->with('getorder',$getorder)
            ->with('slider',$slider)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical)
            ->with('category_post',$category_post)
            ->with('cate_product',$cate_product)
            ->with('brand_product',$brand_product)
            ;
        }
    }

    public function view_history_order(Request $request,$order_code) {
        if (!Session::get('customer_id')) {
           return redirect('login-checkout')->with('error','Vui lòng đăng nhập để xem lịch sử đơn hàng');
        } else {
           

            $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();
            $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
            $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_parent","desc")->orderBy("category_order","desc")->get();
            $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
            $meta_desc = 'Lịch sử đặt hàng';
            $meta_keywords = 'Lịch sử đặt hàng';
            $meta_title = "Lịch sử đặt hàng";
            $url_canonical = $request->url();

            $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
            $order = Order::where('order_code',$order_code)->get();
            foreach($order as $key => $ord) {
                $customer_id = $ord->customer_id;
                $shipping_id = $ord->shipping_id;
                $order_status = $ord->order_status;
            }
            $customer = Customer::where('customer_id',$customer_id)->first();
            $shipping = Shipping::where('shipping_id',$shipping_id)->first();
    
            $order_details_product = OrderDetails::with('product')->where('order_code',$order_code)->get();
    
          
            foreach($order_details_product as $key => $ord_d){
                $product_coupon = $ord_d->product_coupon;
            }
    
            if ($product_coupon != 'no') {
                $coupon = Coupon::where('coupon_code',$product_coupon)->first();
                $coupon_condition = $coupon->coupon_condition;
                $coupon_number = $coupon->coupon_number;
            } else {
                $coupon_condition = 2;
                $coupon_number = 0;
            }

            return view('pages.history.view_history_order')
            ->with('slider',$slider)
            ->with('customer',$customer)
            ->with('coupon_condition',$coupon_condition)
            ->with('coupon_number',$coupon_number)
            ->with('shipping',$shipping)
            ->with('order_details',$order_details)
            ->with('order_status',$order_status)
            ->with('meta_desc',$meta_desc)
            ->with('meta_keywords',$meta_keywords)
            ->with('meta_title',$meta_title)
            ->with('url_canonical',$url_canonical)
            ->with('category_post',$category_post)
            ->with('cate_product',$cate_product)
            ->with('brand_product',$brand_product)
            ;
        }
    }
}
