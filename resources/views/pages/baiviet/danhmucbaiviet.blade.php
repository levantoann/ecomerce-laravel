@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
					<h2 class="title text-center">{{$meta_title}}</h2>
						<div class="product-image">
							@foreach ($post as $key => $p)
								<div class="single-products" style="margin: 10px 0;">
										<div class="text-center">	
											
											<img style="float:left;width: 30%;padding: 5px;" src="{{URL::to('uploads/post/'.$p->post_image)}}" alt="" />
											<h4 style="color:#000;padding: 5px;">{{$p->post_title}}</h4>
											
											<p class="font-size-15">{!!$p->post_desc!!}</p>
                                              <div class="text-right">

												  <a href="{{URL::to('/bai-viet/'.$p->post_slug)}}" class="btn btn-warning btn-sm">Xem bài viết</a>
											  </div>
	
										</div>
								</div>
								<div class="clearfix"></div>
								@endforeach
							</div>
					
						
					</div><!--features_items-->
					<ul class="pagination pagination-sm m-t-none m-b-none">
						{!!$post->links()!!}
					</ul>
                  
					@endsection