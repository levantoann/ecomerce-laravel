<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Feeship;
use App\Models\Order;
use App\Models\Shipping;
use PDF;

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
    
        // Kiểm tra trạng thái đơn hàng đã xử lý
        if ($order->order_status == 2) {  
            foreach ($data['order_product_id'] as $key => $product_id) {
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
    
                // Kiểm tra và cập nhật số lượng tồn kho và số lượng đã bán
                $qty = $data['quantity'][$key];  // Lấy số lượng sản phẩm từ mảng quantity
    
                if ($product_quantity >= $qty) {
                    // Cập nhật số lượng tồn kho và số lượng đã bán
                    $pro_remain = $product_quantity - $qty;
                    $product->product_quantity = $pro_remain;  // Cập nhật kho
                    $product->product_sold = $product_sold + $qty; // Cập nhật số lượng đã bán
                    $product->save();
                }
            }
        } elseif ($order->order_status != 2 && $order->order_status != 3) {
            // Nếu trạng thái đơn hàng không phải là 'đã xử lý'
            foreach ($data['order_product_id'] as $key => $product_id) {
                $product = Product::find($product_id);
                $product_quantity = $product->product_quantity;
                $product_sold = $product->product_sold;
    
                // Lấy số lượng sản phẩm cần cập nhật
                $qty = $data['quantity'][$key];
    
                if ($product_quantity + $qty >= 0) {
                    // Cập nhật lại kho và số lượng đã bán (khi không phải trạng thái đã xử lý)
                    $pro_remain = $product_quantity + $qty;
                    $product->product_quantity = $pro_remain;  // Cập nhật kho
                    $product->product_sold = $product_sold - $qty; // Cập nhật số lượng đã bán
                    $product->save();
                }
            }
        }
    }
    
    

    public function update_qty(Request $request) {
        $data = $request->all();
        $order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();

        $order_details->product_sales_quantity = $data['order_qty'];
        $order_details->save();

        
    }
}
