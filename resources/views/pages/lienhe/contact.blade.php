@extends('welcome')
@section('content')
<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Liên hệ</h2>
						
						<div class="row">
                            @foreach ($contact as $key => $cont)
                            
                            <div class="col-md-12">
                                <h4>Thông tin liên hệ</h4>
                                {!!$cont->info_contact!!}
                                <p><b>Fange:</b></p>
                                {!!$cont->info_fange!!}
                            </div>
                            <div class="col-md-12">
                                <p><b>Bản đồ</b></p>
                                {!!$cont->info_map!!}
                            </div>
                        </div>
                            @endforeach
						</div>

                  
					@endsection