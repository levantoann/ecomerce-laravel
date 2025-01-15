<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}">
    <meta name="robots" content="INDEX, FOLLOW">
    <meta name="author" content="">
    <meta rel="canonical" content="{{$url_canonical}}">

	<meta property="og:site_name" content="">
	<meta property="og:description" content="{{$meta_desc}}">
	<meta property="og:title" content="{{$meta_title}}">
	<meta property="og:url" content="{{$url_canonical}}">
	<meta property="og:type" content="website">
	<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$meta_title}}</title>
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/sweetalert.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/vlite.css')}}" rel="stylesheet" />
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

	

	
	<link href="{{asset('frontend/css/lightslider.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/prettify.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/lightgallery.min.css')}}" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('frontend/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('frontend/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('frontend/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('frontend/images/ico/apple-touch-icon-57-precomposed.png')}}">
</head><!--/head-->

<body>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								@foreach ($icons as $key => $ico)
								
								<li><a target="_blank" href="{{$ico->link}}">
									<img style="margin: 4px;" height="32px" width="32px" src="{{asset('uploads/icon/'.$ico->image)}}" alt="">
								</a></li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="{{URL::to('/trang-chu')}}"><img src="{{asset('frontend/images/home/logo.png')}}" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canada</a></li>
									<li><a href="#">UK</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canadian Dollar</a></li>
									<li><a href="#">Pound</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>
								<?php 
									$customer_id = Session::get("customer_id");
									$shipping_id = Session::get("shipping_id");
									if ($customer_id!=NULL && $shipping_id==NULL) { 
										?>
									<li><a href="{{URL::to('/checkout')}}"><i class="fa fa-lock"></i> Thanh toán</a></li>
									<?php 
									} elseif($customer_id!=NULL && $shipping_id!=NULL) { 
										?>
									<li><a href="{{URL::to('/payment')}}"><i class="fa fa-credit-card"></i> Thanh toán</a></li>
										<?php 
									} else {
										?>
										<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-credit-card"></i> Thanh toán</a></li>
									<?php
									}
									?>


									<style>
										span#show-cart li {
											margin-top: 9px;
										}
									</style>
									<span id="show-cart"></span>
								

								<?php 
									$customer_id = Session::get("customer_id");
									if ($customer_id!=NULL) { 
										?>
									<li><a href="{{URL::to('/history')}}"><i class="fa fa-history"></i> Lịch sử đơn hàng </a></li>
								<?php	
								}
								?>

								
								<?php 
									$customer_id = Session::get("customer_id");
									if ($customer_id!=NULL) { 
										?>
									<li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-sign-out"></i> Đăng xuất</a>
									<img src="{{Session::get('customer_picture')}}" width="15%" alt=""> {{Session::get('customer_name')}}</li>
									<?php 
									} else { 
										?>
								<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-user"></i> Đăng nhập</a></li>
										<?php 
									}
									?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-7">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{URL::to('/trang-chu')}}" class="active">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
										@foreach ($cate_product as $key => $cate )
										@if ($cate->category_parent==0)
										
                                        <li><a href="{{URL::to('/danh-muc-san-pham/'.$cate->slug_category_product)}}">{{$cate->category_name}}</a></li>
										@foreach ($cate_product as $key => $cate_sub)
										@if ($cate_sub->category_parent==$cate->category_id)
										<ul>
											<li><a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->slug_category_product)}}">{{$cate_sub->category_name}}</a></li>
										</ul>
										@endif
										@endforeach
										@endif
										@endforeach
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="#">Tin Tức<i class="fa fa-angle-down"></i></a>
								
								<ul role="menu" class="sub-menu">
									@foreach ($category_post as $key => $danhmucbaiviet)
										<li><a href="{{URL::to('/danh-muc-bai-viet/'.$danhmucbaiviet->cate_post_slug)}}">{{$danhmucbaiviet->cate_post_name}}</a></li>
									@endforeach
								</ul>
                                </li> 
								<li><a href="{{URL::to('/show-cart')}}">Giỏ hàng</a></li>
								<li><a href="{{URL::to('/video-shop')}}">Video</a></li>
								<li><a href="{{URL::to('/lien-he')}}">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-5">
						<form action="{{URL::to('/tim-kiem')}}" autocomplete="off" method="post">
							{{csrf_field()}}
							<div class="search_box pull-right">
								<input type="text" name="keywords_submit" id="keywords" placeholder="Tìm kiếm sản phẩm"/>
								<input type="submit" name="search_items" style="margin-top:0;color:#666" class="btn btn-primary btn-sm" value="Tìm kiếm">
								<div id="search_ajax"></div>
							</div>
						</form>
							
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						
						<div class="carousel-inner">
							@php
							$i = 0;
							@endphp
						@foreach ($slider as $key => $slide )
						@php
						$i++;
						@endphp
							<div class="item {{ $i == 1 ? 'active' : '' }}">
								<div class="col-sm-12">
									<img src="{{ asset('uploads/slider/'.$slide->slider_image) }}" style="width:100%" class="img img-responsive" alt="" />
								</div>
							</div>
							
							
							@endforeach
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh mục sản phẩm</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							
						@foreach ($cate_product as $key => $cate)
						@if ($cate->category_parent == 0)
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#{{$cate->slug_category_product}}">
										<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											{{$cate->category_name}}
										</a>
									</h4>
								</div>

								<div id="{{$cate->slug_category_product}}" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>
										@foreach ($cate_product as $key =>$cate_sub)
												@if ($cate_sub->category_parent==$cate->category_id)
												
												<li><a href="{{URL::to('/danh-muc-san-pham/'.$cate_sub->slug_category_product)}}">{{$cate_sub->category_name}} </a></li>
												@endif
											@endforeach
										</ul>
									</div>
								</div>
							</div>
							@endif
							@endforeach
							
						</div><!--/category-products-->

						<div class="brands_products"><!--brands_products-->
							<h2>Thương hiệu sản phẩm</h2>
							@foreach ($brand_product as $key => $brand)
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->slug_brand_product)}}"> <span class="pull-right"></span>{{$brand->brand_name}}</a></li>
								</ul>
							</div>
							
							@endforeach
						</div><!--/brands_products-->
						<div class="brands_products"> 
							
							<h2>Sản phẩm đã xem</h2>
							<div class="brands-name">
								<div id="row_viewed" class="row">
									
								</div>
							</div>
						</div>

						<div class="brands_products"> 
							
							<h2>Sản phẩm yêu thích</h2>
							<div class="brands-name">
								<div id="row_wishlist" class="row">
									
								</div>
							</div>
						</div>
						
						
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					@yield('content')
					
					
					
					
				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>e</span>-shopper</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('frontend/images/home/iframe1.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('frontend/images/home/iframe2.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('frontend/images/home/iframe3.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{asset('frontend/images/home/iframe4.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="{{asset('frontend/images/home/map.png')}}" alt="" />
							<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">Change Location</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Quock Shop</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">T-Shirt</a></li>
								<li><a href="#">Mens</a></li>
								<li><a href="#">Womens</a></li>
								<li><a href="#">Gift Cards</a></li>
								<li><a href="#">Shoes</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Policies</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Terms of Use</a></li>
								<li><a href="#">Privecy Policy</a></li>
								<li><a href="#">Refund Policy</a></li>
								<li><a href="#">Billing System</a></li>
								<li><a href="#">Ticket System</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Company Information</a></li>
								<li><a href="#">Careers</a></li>
								<li><a href="#">Store Location</a></li>
								<li><a href="#">Affillate Program</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>About Shopper</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <script src="{{asset('frontend/js/jquery.js')}}"></script>
	
	<script src="{{asset('frontend/js/vlite.js')}}"></script>
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('frontend/js/price-range.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
	<script src="{{asset('frontend/js/sweetalert.js')}}"></script>

	<script src="{{asset('frontend/js/lightslider.js')}}"></script>
	<script src="{{asset('frontend/js/lightgallery-all.min.js')}}"></script>
	<script src="{{asset('frontend/js/prettify.js')}}"></script>
	

	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v21.0"></script>
	
	<script type="text/javascript">
		$(document).ready(function() {
		// 		var cate_id = $('.tabs_pro').val();
		// 		var _token = $('input[name="_token"]').val();
		// 		$.ajax({
		// 		url: '{{ url('/product-tabs') }}',
		// 		method: 'POST',
		// 		headers:{
        //         'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        //     },
		// 		data: { cate_id:cate_id},
		// 		success: function (data) {
        //         $('#tabs_product').html(data); // Đổ dữ liệu vào select tương ứng
        //     },
        // });
		$('.tabs_pro').click(function(){
				var cate_id = $(this).data('id');
				var _token = $('input[name="_token"]').val();
				$.ajax({
				url: '{{ url('/product-tabs') }}',
				method: 'POST',
				headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
				data: { cate_id:cate_id},
				success: function (data) {
					$('#tabs_product').html(data); 
            },
        });
			})
		})
		</script>


	<script type="text/javascript">
		$(document).ready(function() {

			
			load_comment();
			function load_comment() {
				var product_id = $('.comment_product_id').val();
				var _token = $('input[name="_token"]').val();
				$.ajax({
				url: '{{ url('/load-comment') }}',
				method: 'POST',
				headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
				data: { product_id:product_id},
				success: function (data) {
                $('#comment_show').html(data); // Đổ dữ liệu vào select tương ứng
            },
        });
			}
			$('.send-comment').click(function(){
				var product_id = $('.comment_product_id').val();
				var comment_name = $('.comment_name').val();
				var comment_content = $('.comment_content').val();
				var _token = $('input[name="_token"]').val();
				$.ajax({
				url: '{{ url('/send-comment') }}',
				method: 'POST',
				headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
				data: { product_id:product_id,comment_name:comment_name,comment_content:comment_content},
				success: function (data) {
					$('#notify-comment').html('<p class="text text-success">Thêm bình luận thành công</p>'); // Hiển thị thông báo
					load_comment();
					$('#notify-comment').fadeOut(2000);
					$('.comment_name').val('')
					$('.comment_content').val('')
            },
        });
			})
		})
	</script>

	<script type="text/javascript">
		function remove_background(product_id){
			for(var count = 1; count <= 5; count++)
		{
			$('#'+product_id+'-'+count).css('color','#ccc');
		}
		}
		$(document).on('mouseenter','.rating',function() {
			var index = $(this).data("index");
			var product_id = $(this).data("product_id");	
			remove_background(product_id);
			
			for(var count = 1; count <= index; count++)
		{
			$('#'+product_id+'-'+count).css('color','#ffcc00');
		}
		});
		$(document).on('mouseleave','.rating',function() {
			var index = $(this).data("index");
			var product_id = $(this).data("product_id");	
			var rating = $(this).data("rating");	
			remove_background(product_id);
			
			for(var count = 1; count <= rating; count++)
		{
			$('#'+product_id+'-'+count).css('color','#ffcc00');
		}
		})
		$(document).on('click','.rating',function() {
			var index = $(this).data("index");
			var product_id = $(this).data("product_id");	
			var _token = $('input[name="_token"]').val();
			$.ajax({
            url: '{{ url('/insert-rating') }}',
            method: 'POST',
			headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            data: { index:index, product_id:product_id},
            success: function (data) {
              if (data == 'done') {
					alert("Bạn đã đánh giá "+index+" sao trên 5 sao");
			  } else {
					alert("Lỗi đánh giá")
			  }
            },
        });
		})
	</script>

	<script type="text/javascript">
		$('#keywords').keyup(function(){	
			var query = $(this).val();
			if (query != '') {
			var _token = $('input[name="_token"]').val();
			$.ajax({
            url: '{{ url('/autocomplete-ajax') }}',
            method: 'POST',
            data: { query:query, _token: _token },
            success: function (data) {
                $('#search_ajax').fadeIn(); // Đổ dữ liệu vào select tương ứng
                $('#search_ajax').html(data); // Đổ dữ liệu vào select tương ứng
            },
        });
			} else {
				$('#search_ajax').fadeOut();
			}
		});
	 $(document).on('click','.li_search_ajax',function() {
		$('#keywords').val($(this).text());
		$('#search_ajax').fadeOut();
	 })
	 </script>

<script type="text/javascript">
	function viewed(){
		if (localStorage.getItem('viewed')!=null) {
			var data = JSON.parse(localStorage.getItem('viewed'));
			data.reverse();
			document.getElementById('row_viewed').style.overflow + 'scroll';
			document.getElementById('row_viewed').style.height + '600px';

			for(i=0;i<data.length;i++){
				var name = data[i].name;
				var price = data[i].price;
				var image = data[i].image;
				var url = data[i].url;
				var formattedPrice = parseFloat(price).toLocaleString('vi-VN') + ' VNĐ';

	// Thêm sản phẩm vào danh sách
				$("#row_viewed").append('<div class="row" style="margin: 10px 0"><div class="col-md-4"><img width="100%" src="'+image+'" alt=""></div><div class="col-md-8 info_wishlist"><p>'+name+'</p><p style="color:#FE980F">'+formattedPrice+'</p><p><a href="'+url+'">Đặt hàng</a></p></div></div>');
			}
		}
	}
	viewed();

	product_viewed();
function product_viewed(){
		var id_product = $('#product_viewed_id').val();
		if (id_product != undefined) {
			var id = id_product;
			var name = document.getElementById('viewed_productname'+id).value;
		var price = document.getElementById('viewed_productprice'+id).value;
		var image = document.getElementById('viewed_productimage'+id).src;
		var url = document.getElementById('viewed_producturl'+id).value;
		var newItem = {
			'url':url,
			'id':id,
			'name':name,
			'price':price,
			'image':image,
		}
		if (localStorage.getItem('data')==null) {
			localStorage.setItem('data', '[]');
		}

		var old_data =JSON.parse(localStorage.getItem('data'));


		var matches = $.grep(old_data, function(obj){
			return obj.id == id;
		})
		if (matches.length) {
			alert('Sản phẩm bạn đã yêu thích, nên không thể thêm');
		}
		else {
			old_data.push(newItem);
			$("#row_viewed").append('<div class="row" style="margin: 10px 0"><div class="col-md-4"><img width="100%" src="'+newItem.image+
				'" alt=""></div><div class="col-md-8 info_wishlist"><p>'+newItem.name+'</p><p style="color:#FE980F">'+newItem.price+'</p><p><a href="'+newItem.url+
				'">Đặt hàng</a></p></div></div>');
		}
		localStorage.setItem('viewed',JSON.stringify(old_data));
		}
		
	}
</script>

<script>
	function add_compare(product_id){
		document.getElementById('title-compare').innerText = 'Chỉ cho phép so sánh tối đa 3 sản phẩm'
		var id = product_id;
		var name = document.getElementById('wishlist_productname'+id).value;
		var price = document.getElementById('wishlist_productprice'+id).value;
		var image = document.getElementById('wishlist_productimage'+id).src;
		var url = document.getElementById('wishlist_producturl'+id).href;
		var newItem = {
			'url':url,
			'id':id,
			'name':name,
			'price':price,
			'image':image,
		}
		if (localStorage.getItem('compare')==null) {
			localStorage.setItem('compare', '[]');
		}

		var old_data =JSON.parse(localStorage.getItem('compare'));


		var matches = $.grep(old_data, function(obj){
			return obj.id == id;
		})
		if (matches.length) {
		}
		else {
			if(old_data.length < 3) {
				old_data.push(newItem);
				$('#row_compare').find('tbody').append(`
					<tr id="row_compare`+id+`">
					<td>`+newItem.name+`</td>
					<td>`+newItem.price+`</td>
					<td><img width="100%" src="`+image+`" alt=""></td>
					<td></td>
					<td></td>
					<td></td>
					<td><a href="`+newItem.url+`">Xem sản phẩm</a></td>
					<td><a style="cursor:pointer" onclick="delete_compare(`+id+`)">Xóa so sánh</a></td>
				</tr>
				`);
			}
		}
		localStorage.setItem('compare',JSON.stringify(old_data));
		$('#compare').modal();
	}

	function delete_compare(id) {
		if (localStorage.getItem('compare')!=null) {
			var data = JSON.parse(localStorage.getItem('compare'));
			var index =data.findIndex(item => item.id === id);
			data.splice(index,1);
			localStorage.setItem('compare', JSON.stringify(data));
			document.getElementById("row_compare"+id).remove();
		}
	}

	sosanh();

	function sosanh(){
		if (localStorage.getItem('compare')!=null) {
			var data = JSON.parse(localStorage.getItem('compare'));

			for(i=0;i<data.length;i++) {
				var name = data[i].name;
				var price = data[i].price;
				var image = data[i].image;
				var url = data[i].url;
				var id = data[i].id;

				$('#row_compare').find('tbody').append(`
				<tr id="row_compare`+id+`">
					<td>`+name+`</td>
					<td>`+price+`</td>
					<td><img width="100%" src="`+image+`" alt=""></td>
					<td></td>
					<td></td>
					<td></td>
					<td><a href="`+url+`">Xem sản phẩm</a></td>
					<td><a style="cursor:pointer" onclick="delete_compare(`+id+`)">Xóa so sánh</a></td>
				</tr>
				`);
			}
		}
	}
</script>

<script type="text/javascript">
	function view(){
		if (localStorage.getItem('data')!=null) {
			var data = JSON.parse(localStorage.getItem('data'));
			data.reverse();
			document.getElementById('row_wishlist').style.overflow + 'scroll';
			document.getElementById('row_wishlist').style.height + '600px';

			for(i=0;i<data.length;i++){
				var name = data[i].name;
				var price = data[i].price;
				var image = data[i].image;
				var url = data[i].url;
				var formattedPrice = parseFloat(price).toLocaleString('vi-VN') + ' VNĐ';

	// Thêm sản phẩm vào danh sách
				$("#row_wishlist").append('<div class="row" style="margin: 10px 0"><div class="col-md-4"><img width="100%" src="'+image+'" alt=""></div><div class="col-md-8 info_wishlist"><p>'+name+'</p><p style="color:#FE980F">'+formattedPrice+'</p><p><a href="'+url+'">Đặt hàng</a></p></div></div>');
			}
		}
	}
	view();

	function add_wishlist(clicked_id){
		var id = clicked_id;
		var name = document.getElementById('wishlist_productname'+id).value;
		var price = document.getElementById('wishlist_productprice'+id).value;
		var image = document.getElementById('wishlist_productimage'+id).src;
		var url = document.getElementById('wishlist_producturl'+id).href;
		var newItem = {
			'url':url,
			'id':id,
			'name':name,
			'price':price,
			'image':image,
		}
		if (localStorage.getItem('data')==null) {
			localStorage.setItem('data', '[]');
		}

		var old_data =JSON.parse(localStorage.getItem('data'));


		var matches = $.grep(old_data, function(obj){
			return obj.id == id;
		})
		if (matches.length) {
			alert('Sản phẩm bạn đã yêu thích, nên không thể thêm');
		}
		else {
			old_data.push(newItem);
			$("#row_wishlist").append('<div class="row" style="margin: 10px 0"><div class="col-md-4"><img width="100%" src="'+newItem.image+
				'" alt=""></div><div class="col-md-8 info_wishlist"><p>'+newItem.name+'</p><p style="color:#FE980F">'+newItem.price+'</p><p><a href="'+newItem.url+
				'">Đặt hàng</a></p></div></div>');
		}
		localStorage.setItem('data',JSON.stringify(old_data));
	}
	</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#sort').on('change', function(){
			var url = $(this).val();
			if (url) {
				window.location = url;
			}
			  return false;
		})
	})
</script>

<script type="text/javascript">
	 $('.xemnhanh').click(function() {
		var product_id = $(this).data('id_product');
        var _token = $('input[name="_token"]').val(); // CSRF token
        $.ajax({
            url: '{{ url('/quickview') }}',
            method: 'POST',
			dataType:"JSON",
            data:{product_id:product_id, _token:_token}, 
            success:function(data){
                $('#product_quickview_title').html(data.product_name); // Đổ dữ liệu nhận về vào phần tử #gallery_load
                $('#product_quickview_id').html(data.product_id); // Đổ dữ liệu nhận về vào phần tử #gallery_load
                $('#product_quickview_price').html(data.product_price);
                $('#product_quickview_image').html(data.product_image);
                $('#product_quickview_gallery').html(data.product_gallery);
                $('#product_quickview_desc').html(data.product_desc);
                $('#product_quickview_content').html(data.product_content);
                $('#product_quickview_value').html(data.product_value);
            },
        });
	 })
	</script>

	<script type="text/javascript">
	 $(document).ready(function() {
    $('#imageGallery').lightSlider({
        gallery:true,
        item:1,
        loop:true,
        thumbItem:9,
        slideMargin:0,
        enableDrag: false,
        currentPagerPosition:'left',
        onSliderLoad: function(el) {
            el.lightGallery({
                selector: '#imageGallery .lslide'
            });
        }   
    });  
  });
	</script>
	<script type="text/javascript">
    $(document).on('click','.watch-video',function(){
        var video_id = $(this).attr('id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"{{url('/watch-video')}}",
            method:"POST",
            dataType:"JSON",
            data:{video_id:video_id, _token:_token}, 
            success:function(data){
                $('#video_title').html(data.video_title); // Đổ dữ liệu nhận về vào phần tử #gallery_load
                $('#video_link').html(data.video_link); // Đổ dữ liệu nhận về vào phần tử #gallery_load
                $('#video_desc').html(data.video_desc); // Đổ dữ liệu nhận về vào phần tử #gallery_load
				//Youtube example
			var playerYT = new vLite({
				selector: '#example',
				options: {
					"autoplay": false,
					"controls": true,
					"playPause": true,
					"time": true,
					"timeline": true,
					"volume": true,
					"fullscreen": true,
					"poster": "img/poster.jpg",
					"bigPlay": true,
					"nativeControlsForTouch": true
				},
				callback: (player) => {
					//Ready
				}
			});
            }
        }); 
});
</script>
<script>
	function Addtocart(product_id) {
    var cart_product_id = $('.cart_product_id_' + product_id).val();
    var cart_product_name = $('.cart_product_name_' + product_id).val();
    var cart_product_image = $('.cart_product_image_' + product_id).val();
    var cart_product_price = $('.cart_product_price_' + product_id).val();
    var cart_product_quantity = $('.cart_product_quantity_' + product_id).val();
    var cart_product_qty = $('.cart_product_qty_' + product_id).val();
    var _token = $('input[name="_token"]').val();

    // Kiểm tra số lượng sản phẩm
    if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
        alert('Vui lòng đặt số lượng nhỏ hơn hoặc bằng ' + cart_product_quantity);
        return;
    }

    // Gửi dữ liệu qua AJAX
    $.ajax({
        url: '{{url('/add-cart-ajax')}}',
        method: 'POST',
        data: {
            cart_product_id: cart_product_id,
            cart_product_name: cart_product_name,
            cart_product_image: cart_product_image,
            cart_product_price: cart_product_price,
            cart_product_qty: cart_product_qty,
            cart_product_quantity: cart_product_quantity,
            _token: _token
        },
        success: function() {
            swal({
                title: "Đã thêm sản phẩm vào giỏ hàng",
                text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để thanh toán.",
                showCancelButton: true,
                cancelButtonText: "Xem tiếp",
                confirmButtonClass: "btn-success",
                confirmButtonText: "Đi đến giỏ hàng",
                closeOnConfirm: false
            }, function() {
                window.location.href = "{{url('/gio-hang')}}";
            });
        },
        error: function(xhr) {
            console.error("Lỗi AJAX: ", xhr); // Ghi log lỗi nếu AJAX thất bại
        }
    });
}
</script>
<script type="text/javascript">
	show_cart();
	function show_cart(){
		$.ajax({
                url: '{{ url('/show-cart-manage') }}',
                method: 'GET',
                success: function (data) {
                    $('#show-cart').html(data);
                },
            });
	}
            $(document).on('click','.add-to-cart','.add-to-cart-quickview',function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
				if (parseInt(cart_product_qty)>parseInt(cart_product_quantity)) {
					alert('Vui lòng đặt số lượng nhỏ hơn ' + cart_product_quantity);
				}else {

				
                $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,
						cart_product_image:cart_product_image,cart_product_price:cart_product_price,
						cart_product_qty:cart_product_qty,_token:_token,cart_product_quantity:cart_product_quantity},
                    success:function(){
						swal({
                                title: "Đã thêm sản phẩm vào giỏ hàng",
                                text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                showCancelButton: true,
                                cancelButtonText: "Xem tiếp",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Đi đến giỏ hàng",
                                closeOnConfirm: false
                            },
                            function() {
                                window.location.href = "{{url('/gio-hang')}}";
                            });
							show_cart();
                    },
                });
			}
            });
    </script>
	<script type="text/javascript">
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
				if (parseInt(cart_product_qty)>parseInt(cart_product_quantity)) {
					alert('Vui lòng đặt số lượng nhỏ hơn ' + cart_product_quantity);
				}else {

				
                $.ajax({
                    url: '{{url('/add-cart-ajax')}}',
                    method: 'POST',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,
						cart_product_image:cart_product_image,cart_product_price:cart_product_price,
						cart_product_qty:cart_product_qty,_token:_token,cart_product_quantity:cart_product_quantity},
                    success:function(){
						swal({
                                title: "Đã thêm sản phẩm vào giỏ hàng",
                                text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                showCancelButton: true,
                                cancelButtonText: "Xem tiếp",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Đi đến giỏ hàng",
                                closeOnConfirm: false
                            },
                            function() {
                                window.location.href = "{{url('/gio-hang')}}";
                            });
                       
                    },
                error: function(xhr){
                    console.log("Lỗi AJAX: ", xhr); // Kiểm tra lỗi nếu AJAX thất bại
                }
                });
			}
            });
        });
    </script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.choose').on('change', function () {
            var action = $(this).attr('id'); // Lấy id của phần tử (city, province, wards)
            var ma_id = $(this).val(); // Lấy giá trị của phần tử (id của thành phố, quận)
            var _token = $('input[name="_token"]').val(); // CSRF token
            var result = ''; // Kết quả trả về sẽ được cập nhật vào phần tử này

            // Xác định phần tử cần cập nhật
            if (action == 'city') {
                result = 'province'; // Nếu chọn thành phố thì cập nhật vào quận huyện
            } else if (action == 'province') {
                result = 'wards'; // Nếu chọn quận huyện thì cập nhật vào xã phường
            }

            $.ajax({
                url: '{{ url('/select-delivery-home') }}',
                method: 'POST',
                data: { action: action, ma_id: ma_id, _token: _token },
                success: function (data) {
                    $('#' + result).html(data); // Đổ dữ liệu vào select tương ứng (province hoặc wards)
                },
                error: function () {
                    alert('Có lỗi xảy ra!'); // Hiển thị lỗi nếu có
                }
            });
        });
    });
</script>


<script type="text/javascript">
	$(document).ready(function(){
		$('.calculate_delivery').click(function() {
			var matp = $('.city').val();	
			var maqh = $('.province').val();	
			var xaid = $('.wards').val();	
			var _token = $('input[name="_token"]').val();

			if (matp == '0' || maqh == '0' || xaid == '0') {
				alert('Vui lòng chọn để tính phí vận chuyển');
			} else {
				$.ajax({
            url: '{{ url('/calculate-fee') }}',
            method: 'POST',
            data: { matp:matp, maqh:maqh,xaid:xaid, _token: _token },
            success: function () {
               location.reload(); // Đổ dữ liệu vào select tương ứng
            },
       		 });
			}

		})
	})
</script>
<script type="text/javascript">
	$(document).ready(function(){
    $('.send_order').click(function(){
		swal({
                                title: "Xác nhận đơn hàng",
                                text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
								type: "warning",
                                showCancelButton: true,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Cảm ơn, Mua hàng",
								cancelButtonText: "Đóng",
                                closeOnConfirm: false,
								closeOnCancel: false
                            },
                            function(isConfirm) {
								if (isConfirm) {
									var shipping_email = $('.shipping_email').val();
									var shipping_name = $('.shipping_name').val();
									var shipping_address = $('.shipping_address').val();
									var shipping_phone = $('.shipping_phone').val();
									var shipping_notes = $('.shipping_notes').val();
									var shipping_method = $('.payment_select').val(); // Correct selection
									var order_fee = $('.order_fee').val();
									var order_coupon = $('.order_coupon').val();
									var _token = $('input[name="_token"]').val();

									$.ajax({
										url: '{{url('/confirm-order')}}',
										method: 'POST',
										data: {
											shipping_email: shipping_email,
											shipping_name: shipping_name,
											shipping_address: shipping_address,
											shipping_phone: shipping_phone,
											shipping_notes: shipping_notes,
											shipping_method: shipping_method, // Correct field name
											order_fee: order_fee,
											order_coupon: order_coupon,
											_token: _token
										},
										success: function(){
											swal("Đơn hàng","Đơn hàng của bạn đã được gửi thành công","success")
										}
										
									});
									
									window.setTimeout(function() {
											location.reload();
										},3000)
								} else {
									swal("Đóng","Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng","error")
								}
                            });

							
    });
});

</script>
<script src="{{asset('frontend/js/simple.money.format.js')}}"></script>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

<script>
    $(function() {
        // Cấu hình slider
        $("#slider-range").slider({
            orientation: "horizontal",
            range: true,
            min: {{$min_price}},
            max: {{$max_price}},
            values: [{{$min_price}}, {{$max_price}}], // Giá trị mặc định
            step: 10000,
            slide: function(event, ui) {
                // Cập nhật giá trị khi kéo slider và sử dụng Intl.NumberFormat()
                var formatter = new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND',
                    currencyDisplay: 'code',  // Sử dụng 'code' để hiển thị 'VND'
                    minimumFractionDigits: 0
                });

                var formattedStart = formatter.format(ui.values[0]);
                var formattedEnd = formatter.format(ui.values[1]);
                
                var amount = formattedStart + " - " + formattedEnd;
                $("#amount").val(amount);

                // Cập nhật giá trị cho start_price và end_price
                $("#start_price").val(ui.values[0]);
                $("#end_price").val(ui.values[1]);
            }
        });

        // Hiển thị giá trị ban đầu khi trang tải
        var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            currencyDisplay: 'code',  // Sử dụng 'code' để hiển thị 'VND'
            minimumFractionDigits: 0
        });

        var initialStart = formatter.format($("#slider-range").slider("values", 0));
        var initialEnd = formatter.format($("#slider-range").slider("values", 1));
        var initialAmount = initialStart + " - " + initialEnd;

        $("#amount").val(initialAmount);
    });
</script>



 <script
            src="https://www.paypal.com/sdk/js?client-id=AXWFk6TB1a19MGa6kjLPHY5CAdW4LhZJpd1IfuNK5PAPE1b9hr4dz0aIHj5BVllY7oC8aritrgMKbkBG"
        ></script>
		<script>
    document.addEventListener("DOMContentLoaded", function () {
        var usd = document.getElementById("vnd_to_usd").value; // Lấy giá trị USD từ input hidden

        paypal.Buttons({
            style: {
                size: 'small',  // Kích thước của button
                color: 'gold',  // Màu sắc của button
                shape: 'pill',  // Hình dạng của button
                label: 'checkout',  // Nhãn trên button
            },
            // Tạo đơn hàng
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: usd, // Tổng số tiền (USD)
                            currency_code: 'USD', // Loại tiền tệ
                        },
                    }],
                });
            },

            // Xử lý sau khi thanh toán thành công
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    alert("Cảm ơn bạn đã mua hàng của chúng tôi!");
                    console.log('Transaction completed by ' + details.payer.name.given_name);
                });
            },

            // Xử lý lỗi khi thanh toán
            onError: function (err) {
                console.error('Lỗi khi xử lý thanh toán:', err);
                alert("Đã xảy ra lỗi trong quá trình thanh toán. Vui lòng thử lại.");
            },
        }).render('#paypal-button-container'); // Kết xuất nút PayPal vào phần tử có id 'paypal-button-container'
    });
</script>

</body>
</html>