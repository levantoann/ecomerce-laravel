@extends('welcome')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
			<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang Chủ</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div><!--/breadcrums-->

			

			<div class="register-req">
				<p>Vui lòng sử dụng Đăng ký và Thanh toán để dễ dàng truy cập vào lịch sử đặt hàng của bạn hoặc sử dụng Thanh toán với tư cách Khách</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Điền thông tin gửi hàng</p>
							<div class="form-one">
								<form action="{{URL::to('/save-checkout-customer')}}" method="POST">
									@csrf
									<input type="text" name="shipping_email" class="shipping_email" placeholder="Email*">
									<input type="text" name="shipping_name"  class="shipping_name" placeholder="Họ và tên">
									<input type="text" name="shipping_address"  class="shipping_address" placeholder="Địa chỉ">
									<input type="text" name="shipping_phone"  class="shipping_phone" placeholder="Số điện thoại">
									<textarea name="shipping_notes"  class="shipping_notes"  placeholder="Ghi chú đơn hàng của bạn" rows="16"></textarea>
									@if (Session::get('fee'))
									
									<input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
									@else
									<input type="hidden" name="order_fee" class="order_fee" value="10000">
									@endif

									@if (Session::get('coupon'))
									@foreach (Session::get('coupon') as $key => $cou )
									
									<input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
									@endforeach
									@else
									<input type="hidden" name="order_coupon" class="order_coupon" value="không có">
									@endif
									<div class="">
                                    <div class="form-group" >
									<label for="">Chọn phương thức thanh toán</label>
									<select name="payment_select" class="form-control input-sm m-bot15 payment_select">
										<option value="0">----Thanh toán bằng tiền mặt----</option> 
										<option value="1">----Thanh toán bằng ATM----</option> 
									</select>

									</div>
									</div>
									<input type="button" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm send_order">
								</form>
								<form>
                                    @csrf
                                <div class="form-group">
                                    <label for="">Chọn tỉnh thành phố</label>
                                    <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                        <option value="0">----Chọn thành phố----</option>
                                        @foreach ($city as $key => $ci )
                                        
                                        <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Chọn quận huyện</label>
                                    <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                        <option value="0">----Chọn quận huyện----</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Chọn xã</label>
                                    <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                        <option value="0">----Chọn xã phường----</option>
                                    </select>
                                </div>
								<input type="button" value="Tính phí vận chuyển" name="calculator_order" class="btn btn-primary btn-sm calculate_delivery">
                            </form>
								<!-- {{Session::get('fee')}} -->
							</div>
						</div>
					</div>	
					<div class="col-sm-12 clearfix">
					@if(session()->has('message'))
				<div class="alert alert-success">
					{{session()->get('message')}}
				</div>
				@elseif(session()->has('error'))
				<div class="alert alert-danger">
					{{session()->get('error')}}
				</div>
				@endif
			<div class="table-responsive cart_info">
				<form action="{{url('/update-cart')}}" method="POST">
					@csrf
					<table class="table table-condensed">
						<thead>
							<tr class="cart_menu">
								<td class="image">Hỉnh ảnh</td>
								<td class="description">Tên sản phẩm</td>
								<td class="price">Giá sản phẩm</td>
								<td class="quantity">Số lượng</td>
								<td class="total">Thành tiền</td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							@if (Session::get('cart')==true)
							
							@php
							 $total = 0;
							@endphp
							@foreach (Session::get('cart') as $key => $cart )
							@php
							
							$subtotal = $cart['product_price']*$cart['product_qty'];
							$total += $subtotal;
							@endphp
							<tr>
								<td class="cart_product" style="border-top:none">
									<img src="{{asset('uploads/product/'.$cart['product_image'])}}" style="width:90px" alt=""></img>
								</td>
								<td class="cart_description">
									<h4><a href=""></a></h4>
									<p>{{$cart['product_name']}}</p>
								</td>
								<td class="cart_price">
									<p>{{number_format($cart['product_price'],0,',','.')}}VND</p>
								</td>
								<td class="cart_quantity">
									<div class="cart_quantity_button">
										<form action="{{URL::to('/update-cart-quantity')}}" method="POST">
										   
											<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" size="2">
	
										   
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">
									{{number_format($subtotal,0,',','.')}}d
									</p>
								</td>
								<td class="cart_delete" style="border-top:none">
									<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							
							@endforeach
							<tr>
								<td>
									
						<input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-primary btn-sm">
								</td>
								<td>
								<a class="btn btn-primary check_out" href="{{url('/del-all-product')}}">Xóa tất cả</a></td>
								
									
								<td>
								@if(Session::get('coupon'))
									<a class="btn btn-primary check_out" href="{{url('/unset-coupon')}}">Xóa mã giảm giá</a>
									@endif
								</td>
								<td>
								<li>Tổng <span>{{number_format($total,0,',','.')}}d</span></li>
								@if (Session::get('coupon'))
								<li>
        @foreach (Session::get('coupon') as $key => $cou)
            @if ($cou['coupon_condition'] == 1)
                Mã giảm giá: {{$cou['coupon_number']}}%
                <p>
                    @php
                        $total_coupon = ($total * $cou['coupon_number'])/100;
                     
                    @endphp
                </p>
				@php
				$total_after_coupon = $total - $total_coupon;
				@endphp
            @elseif ($cou['coupon_condition'] == 2)
                Mã giảm giá: {{number_format($cou['coupon_number'], 0, ',', '.')}}k
                <p>
                    @php
                        $total_coupon = $total - $cou['coupon_number'];
						
                    @endphp
                </p>
				@php
				$total_after_coupon =  $total_coupon;
				@endphp
            @endif
			
        @endforeach
   
</li>
@endif
		@if(Session::get('fee'))
		
		<li><a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times"></i></a>	
		Phí vận chuyển <span>{{ number_format(Session::get('fee'), 0, ',', '.').'đ'}}</span></li>
		<?php
			$total_after_fee = $total + Session::get('fee');
		?>
		@endif
		<li>Tổng còn:

		
		@php
			 // Nếu có phí vận chuyển nhưng không có mã giảm giá
			if(Session::get('fee')&& !Session::get('coupon')){
				$total_after = $total_after_fee;
				echo number_format($total_after, 0, ',', '.').'đ';
			}elseif(!Session::get('fee') && Session::get('coupon')){
			  // Nếu có mã giảm giá nhưng không có phí vận chuyển
				$total_after = $total_after_coupon;
				echo number_format($total_after, 0, ',', '.').'đ';
			}elseif(Session::get('fee') && Session::get('coupon')){
				$total_after = $total_after_coupon;
				$total_after = $total_after + Session::get('fee');
				echo number_format($total_after, 0, ',', '.').'đ';
			}elseif(!Session::get('fee') && !Session::get('coupon')){
				$total_after = $total;
				echo number_format($total_after, 0, ',', '.').'đ';
			}
		@endphp
		</li>
		<div class="col-md-12">
			@php
				$vnd_to_usd = $total_after/23083;
			@endphp
			<div id="paypal-button-container"></div>
			<input type="hidden" id="vnd_to_usd" value="{{round($vnd_to_usd,2)}}">
		</div>
		
	
								
							</tr>
							@else 
							<tr>
								<td colspan="5">
								<center>

								@php 
								echo 'Vui lòng thêm sản phẩm vào giỏ hàng';
								@endphp
								</center>
								</td>
							</tr>
							@endif
						</tbody>
						</form>
						@if (Session::get('cart'))
						
						<tr>
						<td colspan="5">
								<form action="{{url('/check-coupon')}}" method="POST">
									@csrf
									<input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá"><br>
									<input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính giảm giá">
									
								</form>
								</td>
						</tr>
						@endif
					</table>
				</form>
			</div>
			</div>			
				</div>
			</div>
		

			
		</div>
	</section> <!--/#cart_items-->
    
@endsection