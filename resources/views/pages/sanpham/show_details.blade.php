@extends('welcome')
@section('content')
@foreach ($product_details as $key => $value )

<div class="product-details"><!--product-details-->
						<nav aria-label="breadcrumb">
						<ol class="breadcrumb" style="background: none;">
							<li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
							<li class="breadcrumb-item"><a href="{{ url('/danh-muc-san-pham/' . $cate_slug) }}">{{ $product_cate }}</a></li>
							<li class="breadcrumb-item" aria-current="page">{{$meta_title}}</li>
						</ol>
						</nav>
						<div class="col-sm-5">
						<ul id="imageGallery">
							@foreach ($gallery as $key => $gal)
							
							<li data-thumb="{{asset('uploads/gallery/'.$gal->gallery_image)}}" data-src="{{asset('uploads/gallery/'.$gal->gallery_image)}}">
								<img width="100%" height="350px" src="{{asset('uploads/gallery/'.$gal->gallery_image)}}" />
							</li>
							@endforeach
							</ul>
							</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{$value->product_name}}</h2>
								<p>Mã ID: {{$value->product_id}}</p>
								<img src="images/product-details/rating.png" alt="" />
								<form action="{{URL::to('/save-cart')}}" method="POST">
									@csrf
											<input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
                                            <input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->product_id}}">
                                          
								<span>
									<span>{{number_format($value->product_price,0,',','.').'VNĐ'}}</span>
								
									<label>Số lượng:</label>
									<input name="qty" type="number" min="1" class="cart_product_qty_{{$value->product_id}}"  value="1" />
									<input name="productid_hidden" type="hidden"  value="{{$value->product_id}}" />
								</span>
								<input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">
								</form>
								<p><b>Tình trạng:</b> Còn hàng</p>
								<p><b>Tình trạng:</b> Mới</p>
								<p><b>Thương hiệu:</b> {{$value->brand_name}}</p>
                                <p><b>Danh mục:</b> {{$value->category_name}}</p>
								<style>
									a.tags_style {
										margin: 3px 2px;
										border: 1px solid;

										height: auto;
										background:#428bca;
										color: #ffff;
										padding: 0;
									}
									a.tags_style:hover{
										background: black;
									}
								</style>
								<fieldset>
									<legend>Tags:</legend>
									<p><i class="fa fa-tag"></i></p>
									@php
										$tags = $value->product_tags;
										$tags = explode(",",$tags);
									@endphp
									@foreach ($tags as $tag)
										<a class="tags_style" href="{{url('/tag/'.Str::slug($tag))}}">{{$tag}}</a>
									@endforeach
								</fieldset>
									<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
@endforeach

                    <div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
                                <li><a href="#companyprofile" data-toggle="tab">Mô tả</a></li>
								<li><a href="#details" data-toggle="tab">Chi tiết</a></li>
								<li class="active"><a href="#reviews" data-toggle="tab">Đánh giá (5)</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="companyprofile" >
								<p>{!!$value->product_desc!!}</p>
							</div>

							<div class="tab-pane fade" id="details" >
								<p>{!!$value->product_content!!}</p>
							</div>
							
							
							
							
							
							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
										<li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
									</ul>
									<style>
										.style_comment{
											border: 1px solid #ddd;
											border-radius: 10px;
											background: #f0f0e9;
										}
									</style>
									<form>
											@csrf
											<input type="hidden" name="comment_status" value="0"> <!-- Đảm bảo gửi comment_status -->
											<input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$value->product_id}}">
											<div id="comment_show"></div>
									</form>
									<p><b>Viết đánh giá</b></p>
									<ul class="list-line" title="Average Rating">
										@for ($count=1; $count<=5;$count++)
										@php
										if($count<=$rating){
											$color = 'color:#ffcc00';
										} else {
											$color = 'color:#ccc';
										}
										@endphp
										<li 
										title="đánh giá"
										id="{{$value->product_id}}-{{$count}}"
										data-index="{{$count}}"
										data-product_id="{{$value->product_id}}"
										data-rating="{{$rating}}" 
										class="rating"
										
										style="cursor: pointer; {{$color}};font-size:30px"
										>&#9733</li>
										@endfor
									</ul>
									
									<form action="#">
										<span >
											<input class="comment_name" style="width: 100%;margin-left: 0;" type="text" placeholder="Your Name"/>
										</span>
										<textarea name="comment" class="comment_content" ></textarea>
										<b>Đánh giá: </b> <img src="images/product-details/rating.png" alt="" />
										<button type="button" class="btn btn-default pull-right send-comment">
											Thêm bình luận
										</button>
										<div id="notify-comment"></div>
									</form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->


                    <div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Sản phẩm gợi ý</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">
                                    @foreach ($related as $key => $lienquan )
                                    
                                    <div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="{{URL::to('public/frontend/image/product/'.$lienquan->product_image)}}" alt="" />
													<h2>{{number_format($lienquan->product_price).' VND'}}</h2>
													<p>{{$lienquan->product_name}}</p>
													<button type="button" class="btn btn-default add-to-cart" ><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
												</div>
											</div>
										</div>
									</div>
                                    @endforeach
								</div>
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->

                    @endsection