<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js" integrity="sha512-7rusk8kGPFynZWu26OKbTeI+QPoYchtxsmPeBqkHIEXJxeun4yJ4ISYe7C6sz9wdxeE1Gk3VxsIWgCZTc+vX3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="container" style="background: #222;border-radius: 12px;padding: 15px;">
        <div class="col-md-12">
            <p style="text-align: center; color: #fff;">
                Đây là email tự động. Quý khách vui lòng không trả lời email này
            </p>

            <div class="row" style="background: pink;padding: 15px;">
               
            <div class="col-md-6" style="text-align: center;font-weight: bold;font-size: 30px;">
                <h4 style="margin: 0;">Công ty bán hàng laravel</h4>
                <h6 style="margin: 0;">Dịch vụ bán hàng - vận chuyển - nhập khẩu chuyên nghiệp</h6>
                </div>

                <div class="col-md-6 logo" style="text-align: center;font-weight: bold;font-size: 30px;">
                    <p>Chào bạn <strong style="color: #000;text-decoration: underline;">{{$shipping_array['customer_name']}}</strong>
                ,chúng tôi đã xác nhận đơn hàng</p>
                </div>

                <div class="col-md-12">
                    <p style="color:#fff;font-size: 17px;">Bạn đã đăng ký dịch vụ tại shop với thông tin như sau</p>
                    <h4 style="color: #000; text-transform: uppercase;">Thông tin đơn hàng</h4>
                    <p>Mã đơn hàng: <strong style="text-transform: uppercase;color: #fff;">{{$code['order_code']}}</strong></p>
                    <p>Mã khuyến mãi áp dụng: <strong style="text-transform: uppercase;color: #fff;">{{$code['coupon_code']}}</strong></p>
                    <p>Phí ship: <strong style="text-transform: uppercase;color: #fff;">{{$shipping_array['fee_ship']}}</strong></p>
                    <p>Dịch vụ: <strong style="text-transform: uppercase;color: #fff;"></strong></p>
                    <h4 style="text-transform: uppercase; color:#000">Thông tin người nhận</h4>
                    <p>Email:
                        @if ($shipping_array['shipping_email']=='')
                            không có
                        @else 
                        <span style="color: #fff;">{{$shipping_array['shipping_email']}}</span>
                        @endif
                    </p>

                    <p>Họ tên người nhận: 
                        @if ($shipping_array['shipping_name']=='')
                        không có
                        @else 
                        <span style="color: #fff;">{{$shipping_array['shipping_name']}}</span>
                        @endif
                    </p>

                    <p>Địa chỉ người nhận: 
                        @if ($shipping_array['shipping_address']=='')
                        không có
                        @else 
                        <span style="color: #fff;">{{$shipping_array['shipping_address']}}</span>
                        @endif
                    </p>

                    <p>Địa chỉ người nhận: 
                        @if ($shipping_array['shipping_phone']=='')
                        không có
                        @else 
                        <span style="color: #fff;">{{$shipping_array['shipping_phone']}}</span>
                        @endif
                    </p>

                    <p>Ghi chú đơn hàng: 
                        @if ($shipping_array['shipping_notes']=='')
                        không có
                        @else 
                        <span style="color: #fff;">{{$shipping_array['shipping_notes']}}</span>
                        @endif
                    </p>

                    <p>Hình thức thanh toán: <strong>
                        @if ($shipping_array['shipping_method']==0)
                        Chuyển khoản
                        @else 
                        Tiền mặt
                        @endif
                        </strong>
                    </p>
                    <p style="color:#fff">Nếu thông tin người nhận hàng không có chúng tôi sẽ liên hệ lại</p>

                    <h4 style="color:#000;text-transform: uppercase;">Sản phẩm đã được chúng tôi xác nhận</h4>
                    <table class="table table-striped" style="border:1px">
                        <thead>
                            <th>Sản phẩm</th>
                            <th>Giá tiền</th>
                            <th>Số lượng đặt hàng</th>
                            <th>Thành tiền</th>
                        </thead>
                        <tbody>
                            @php
                            $subtotal=0;
                            $total=0;
                            @endphp
                            @foreach($cart_array as $cart)
                            @php
                            $subtotal = $cart['product_qty']*$cart['product_price'];
                            $total+=$subtotal;
                            @endphp
                            <tr>
                                <td>{{$cart['product_name']}}</td>
                                <td>{{number_format($cart['product_price'],0,',','.')}} vnđ</td>
                                <td>{{$cart['product_qty']}}</td>
                                <td>{{number_format($subtotal,0,',','.')}} vnđ</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" align="right">Tổng tiền thanh toán: {{number_format($total,0,',','.')}} vnđ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p style="color:#fff;text-align: center; font-size:15px">Xem lại lịch sử đơn hàng: <a target="_blank" href="{{url('/history')}}">Lịch sử đơn hàng</a></p>

            </div>
        </div>
    </div>
</body>
</html>