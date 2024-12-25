@extends('welcome')
@section('content')
<style>
	
</style>
<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Video</h2>
                        @foreach ($all_video as $key => $video)
                        
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">	
										<form>
										@csrf
											<a style="text-decoration: none;" href="">
											<img src="{{asset('uploads/videos/'.$video->video_image)}}" alt="" />
											<h2>{{$video->video_title}}</h2>
											<p>{{$video->video_desc}}</p>
											</a>

											<button type="button" id="{{$video->video_id}}" class="btn btn-primary watch-video" data-toggle="modal" data-target="#exampleModal">
													Xem video
													</button>
										</form>
	
										</div>
								</div>
						
							</div>
						</div>
                        @endforeach
</a>
					
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="video_title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div id="video_desc"></div>
       <div id="video_link"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng video</button>
      </div>
    </div>
  </div>
</div>
					</div><!--features_items-->

					

                  
					@endsection