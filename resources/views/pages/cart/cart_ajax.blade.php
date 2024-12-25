@extends('welcome')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
            <ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang Chủ</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div>
			@if(session()->has('message'))
				<div class="alert alert-success">
					{!!session()->get('message')!!}
				</div>
				@elseif(session()->has('error'))
				<div class="alert alert-danger">
					{!!session()->get('error')!!}
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
								<td class="description">Số lượng tồn</td>
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
								
								<td class="cart_description">
									<h4><a href=""></a></h4>
									<p>{{$cart['product_quantity']}}</p>
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
								@if(Session::get('customer'))
									<a class="btn btn-primary check_out" href="{{url('/unset-coupon')}}">Xóa mã giảm giá</a>
									@endif
								</td>
								<td>
								@if(Session::get('coupon'))
									<a class="btn btn-primary check_out" href="{{url('/checkout')}}">Đặt hàng</a>
									@else
									<a class="btn btn-primary check_out" href="{{url('/login-checkout')}}">Đặt hàng</a>
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
                        $total_coupon = ($total * $cou['coupon_number']) / 100;
                        echo '<p>Tổng giảm giá: '.number_format($total - $total_coupon, 0, ',', '.').'đ</p>';
                    @endphp
                </p>
            @elseif ($cou['coupon_condition'] == 2)
                Mã giảm giá: {{number_format($cou['coupon_number'], 0, ',', '.')}}k
                <p>
                    @php
                        $total_coupon = $total - $cou['coupon_number'];
                        echo '<p><li>Tổng giảm giá: '.number_format($total_coupon, 0, ',', '.').'đ</li></p>';
                    @endphp
                </p>
            @endif
        @endforeach
   
</li>
@endif

								
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
	</section> <!--/#cart_items-->

    <!-- <section id="do_action">
		<div class="container">
			<!-- <div class="heading">
				<h3>What would you like to do next?</h3>
				<p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
			</div> -->
			<!-- <div class="row"> -->
				<!-- <div class="col-sm-6">
					<div class="chose_area">
						<ul class="user_option">
							<li>
								<input type="checkbox">
								<label>Use Coupon Code</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Use Gift Voucher</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Estimate Shipping & Taxes</label>
							</li>
						</ul>
						<ul class="user_info">
							<li class="single_field">
								<label>Country:</label>
								<select>
									<option>United States</option>
									<option>Bangladesh</option>
									<option>UK</option>
									<option>India</option>
									<option>Pakistan</option>
									<option>Ucrane</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
								
							</li>
							<li class="single_field">
								<label>Region / State:</label>
								<select>
									<option>Select</option>
									<option>Dhaka</option>
									<option>London</option>
									<option>Dillih</option>
									<option>Lahore</option>
									<option>Alaska</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
							
							</li>
							<li class="single_field zip-field">
								<label>Zip Code:</label>
								<input type="text">
							</li>
						</ul>
						<a class="btn btn-default update" href="">Get Quotes</a>
						<a class="btn btn-default check_out" href="">Continue</a>
					</div>
				</div> -->
				<!-- <div class="col-sm-6">
					<div class="total_area">
						<ul>
							
						</ul>
						
								<a class="btn btn-default check_out" href="">Thanh Toán</a>
								<a class="btn btn-default check_out" href="">Tính mã giảm giá</a> -->
									
									
							<!-- <a class="btn btn-default update" href="">Update</a> -->
					<!-- </div>
				</div>
			</div>
		</div> -->
	<!-- </section> -->
    @endsection