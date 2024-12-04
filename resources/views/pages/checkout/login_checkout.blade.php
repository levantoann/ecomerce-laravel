@extends('welcome')
@section('content')

<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Đăng nhập tài khoản</h2>
						<form action="{{URL::to('/login-customer')}}" method="POST">
                            {{csrf_field()}}
							<input type="email" name="email_account" placeholder="Nhập email" />
							<input type="password" name="password_account" placeholder="Nhập mật khẩu" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Ghi nhớ đăng nhập
							</span>
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</form>
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