@extends('welcome')
@section('content')

<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
					@if(session()->has('message'))
                        <div class="alert alert-success">
                            {!!session()->get('message')!!}
                        </div>
                        @elseif(session()->has('error'))
                        <div class="alert alert-danger">
                            {!!session()->get('error')!!}
                        </div>
                        @endif
						
						<h2>Đăng nhập tài khoản</h2>
						<form action="{{URL::to('/login-customer')}}" method="POST">
                            {{csrf_field()}}
							<input type="email" name="email_account" placeholder="Nhập email" />
							<input type="password" name="password_account" placeholder="Nhập mật khẩu" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Ghi nhớ đăng nhập
							</span>
							<p></p>
							<span>
								<a href="{{route('quen-mat-khau')}}">Quên mật khẩu</a>
							</span>
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</form>

						<style>
							ul.list-login{
								margin: 10px;
								padding: 0;
							}
							ul.list-login li {	
								display: inline;
								margin: 5px;
							}
						</style>
						<ul class="list-login">
							<li><a href="{{url('login-customer-google')}}"><img width="10%" src="{{asset('uploads/logo/gg.png')}}" alt=""></a></li>
							<li><a href="{{url('login-customer-facebook')}}"><img width="10%" src="{{asset('uploads/logo/facebook.png')}}" alt=""></a></li>
						</ul>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>Đăng ký!</h2>
						<form action="{{URL::to('/add-customer')}}" method="POST">
                            {{csrf_field()}}
							<input name="customer_name" type="text" placeholder="Họ và tên"/>
							<input name="customer_email" type="email" placeholder="Địa chỉ email"/>
							<input name="customer_password" type="password" placeholder="Mật khẩu"/>
							<input name="customer_phone" type="text" placeholder="Số điện thoại"/>
							<button type="submit" class="btn btn-default">Đăng ký</button>
						</form>

						
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
	

@endsection