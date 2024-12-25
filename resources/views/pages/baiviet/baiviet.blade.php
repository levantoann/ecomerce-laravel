@extends('welcome')
@section('content')
<style type="text/css">
	.baiviet ul li {
		padding: 2px;
		font-size: 16px;
	}
	.baiviet ul li a{
		color: #000;
	}
	.baiviet ul li a:hover{
		color: #fe980f;
	}
	.baiviet ul li{
		list-style-type: decimal-leading-zero;
	}
	.mucluc h1 {
		color: brown;
	}
</style>
<div class="features_items"><!--features_items-->
						<h2 style="position: inherit;" class="title text-center">{{$meta_title}}</h2>
						<div class="product-image">
							@foreach ($post as $key => $p)
								<div class="single-products" style="margin: 10px 0;">
										<div class="text-left">	
                                            <p>{!!$p->post_content!!}</p>
										</div>
								</div>
								<div class="clearfix"></div>
								@endforeach
							</div>
					
						
					</div><!--features_items-->

					<h2 style="margin:0;" class="title text-center">Bài viết liên quan</h2>
					<style>
						ul.post_related li{ 
							list-style-type: disc;
							font-size: 16px;
							padding: 6px;
						}
						ul.post_related li a{ 
							color: #000;
							text-decoration: none;
						}
						ul.post_related li a:hover{ 
							color: #fe980f;
						}
					</style>
					<ul class="post_related">
						@foreach ($related as $key => $post_related)
						
						<li><a href="{{url('/bai-viet/'.$post_related->post_slug)}}">{{$post_related->post_title}}</a></li>
						@endforeach
					</ul>
                  
					@endsection