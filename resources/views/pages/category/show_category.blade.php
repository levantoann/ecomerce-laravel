@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
						<div class="fb-like" data-href="http://127.0.0.1:8000/" data-width="" data-layout="" data-action="" data-size="" data-share="true"></div>
                        @foreach ($category_name as $key => $name)
						<h2 class="title text-center">{{$name->category_name}}</h2>
                        @endforeach
						<div class="row">
							<div class="col-md-4">
								<label for="amount">Sắp xếp theo</label>
								<form>
									@csrf
									<select name="sort" id="sort" class="form-control">
										<option value="{{Request::url()}}?sort_by=none">--Lọc--</option>
										<option value="{{Request::url()}}?sort_by=tang_dan">--Giá tăng dần--</option>
										<option value="{{Request::url()}}?sort_by=giam_dan">--Giá giảm dần--</option>
										<option value="{{Request::url()}}?sort_by=kytu_az">A đến Z</option>
										<option value="{{Request::url()}}?sort_by=kytu_za">Z đến A</option>
									</select>
								</form>
							</div>


							<div class="col-md-4">
								<label for="amount">Lọc theo giá</label>
								<form>
									@csrf
									<div id="slider-range"></div>
									<input type="text" name="" id="amount" style="border:0;color:#f6931f;font-weight: bold;">
									<input type="hidden" name="start_price" id="start_price">
									<input type="hidden" name="end_price" id="end_price">
									<br>
								<input type="submit" name="filter_price" value="Lọc giá" class="btn btn-sm btn-default">
								</form>
							</div>
						</div>
						
						<br>


						@foreach ($category_by_id as $key => $product )
						
						<a style="text-decoration: none;" href="{{URL::to('chi-tiet-san-pham/'.$product->slug_product)}}">
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src="{{URL::to('uploads/product/'.$product->product_image)}}" alt="" />
											<h2>{{number_format($product->product_price,0,',','.').' VNĐ'}}</h2>
											<p>{{$product->product_name}}</p>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
										</div>
								</div>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
										<li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
									</ul>
								</div>
							</div>
						</div>
                        </a>
						@endforeach
					
						
					</div><!--features_items-->

                  
					@endsection