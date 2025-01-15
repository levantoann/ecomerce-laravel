@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
							<div class="category-tab">
								<div class="col-sm-12">
								<ul class="nav nav-tabs">
										@php
										
										$i=0;
										
										@endphp
										@foreach ($cate_pro_tabs as $key => $cat_tabs)
										@php
										
										$i++;
										
										@endphp
										<li data-id="{{$cat_tabs->category_id}}" id="{{$i==1 ? 'tabs_id' : ''}}" class="{{$i==1 ? 'active' : ''}} tabs_pro">
											<a href="#{{$cat_tabs->slug_category_product}}" data-toggle="tab">{{$cat_tabs->category_name}}</a>
										</li>
										@endforeach
									</ul>
								</div>
								<div id="tabs_product"></div>
							</div>


						<h2 class="title text-center">Sản phẩm mới nhất</h2>
						@foreach ($all_product as $key => $product )
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">	
										<form >
										@csrf
											<input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
											<input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
											<input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
											<input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
											<input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
											<input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
											<a id="wishlist_producturl{{$product->product_id}}" style="text-decoration: none;" href="{{URL::to('chi-tiet-san-pham/'.$product->slug_product)}}">
											<img id="wishlist_productimage{{$product->product_id}}" src="{{URL::to('uploads/product/'.$product->product_image)}}" alt="" />
											<h2>{{number_format($product->product_price,0,',','.').'VNĐ'}}</h2>
											<p>{{$product->product_name}}</p>
											</a>

											<button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng</button>
											<button type="button" data-toggle="modal" data-target="#xemnhanh" class="btn btn-default xemnhanh" data-id_product="{{$product->product_id}}" name="add-to-cart">Xem nhanh</button>
										</form>
	
										</div>
								</div>

								<style>
									ul.nav.nav-pills.nav-justified li{
										text-align: center;
										font-size: 13px;
									}
									.button_wishlist{
										border: none;
										background:#ffff;
										color: #B3AFA8;
									}
									ul.nav.nav-pills.nav-justified i {
										color: #B3AFA8;
									}
									.button_wishlist span:hover {
										color: #FE980F;
									}
									.button_wishlist:focus {
										border: none;
										outline: none;
									}

								</style>
								<div class="choose">
									<ul class="nav nav-pills nav-justified">
										<li><a href="#"><i class="fa fa-plus-square"></i><button class="button_wishlist" id="{{$product->product_id}}" onclick="add_wishlist(this.id);"><span>Yêu thích</span></button></a></li>
										<li><a style="cursor: pointer;" onclick="add_compare({{$product->product_id}})"><i class="fa fa-plus-square"></i>So sánh</a></li>
										<div class="container">

										<!-- Modal -->
										<div class="modal fade" id="compare" role="dialog">
											<div class="modal-dialog">
											
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><span id="title-compare"></span></h4>
												</div>
												<div class="modal-body">
												<!-- <div id="row_compare"></div> -->
												 <table class="table table-hover" id="row_compare">
													<thead>
														<tr>
															<th>Tên sản phẩm</th>
															<th>Giá</th>
															<th>Hình ảnh</th>
															<th>Thông số kỹ thuật</th>
															<th>Xem sản phẩm</th>
															<th>Xóa</th>
														</tr>
													</thead>
													<tbody>

													</tbody>
												 </table>
												</div>
												<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												</div>
											</div>
											
											</div>
										</div>
										
										</div>

									</ul>
								</div>
							</div>
						</div>
</a>
						@endforeach
					
						
					</div><!--features_items-->

					<div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title product_quickview_title" id="exampleModalLabel">
									<span id="product_quickview_title">
								</span></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<style>
									@media screen and (min-width:768px) {
										.modal-dialog {
											width: 700px;
										}
										.modal-sm {
											width: 350px;
										}
									}
									@media screen and (min-width:992px) {
										.modal-lg {
											width: 950px;
										}
									}
								</style>
								<div class="row">

									<div class="col-md-5">
										<span id="product_quickview_image"></span>
										<span id="product_quickview_gallery"></span>
									</div>
									<form action="">
										@csrf
										<div id="product_quickview_value">

											<div class="col-md-7">
											<span id="product_quickview_title"></span>
											<p>Mã ID: <span id="product_quickview_id"></span></p>
											<p style="font-size: 20px; color:brown;font-weight: bold;">Giá sản phẩm:<span id="product_quickview_price"></span></p>
		
											<span>
										
											<label>Số lượng:</label>
											<input name="qty" type="number" min="1" class="cart_product_qty_"  value="1" />
											<h4 style="font-size: 20px; color:brown;font-weight: bold;">Mô tả sản phẩm</h4>
											<p><span id="product_quickview_desc"></span></p>
											<p><span id="product_quickview_content"></span></p>
										</span>
										<input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart-quickview" data-id_product="{{$product->product_id}}" name="add-to-cart">
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
							</div>
							</div>
						</div>
						</div>

                  
					@endsection