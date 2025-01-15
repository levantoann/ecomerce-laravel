    @extends('welcome')
    @section('content')

    <section id="form"><!--form-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-1">
                        <div class="login-form"><!--login form-->
                            <h2>Điền mật khẩu mới</h2>
                            @if(session()->has('success'))
                            <div class="alert alert-success">
                                {!!session()->get('success')!!}
                            </div>
                            @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {!!session()->get('error')!!}
                            </div>
                            @endif
                            @php
                            $token = $_GET['token'];
                            $email = $_GET['email'];
                            @endphp
                            <form action="{{URL::to('/reset-new-pass')}}" method="POST">
                                {{csrf_field()}}
                                <input type="hidden" name="email" value="{{$email}}">
                                <input type="hidden" name="token" value="{{$token}}">
                                <input type="text" name="password_account" placeholder="Nhập mật khẩu mới" />
                                <button type="submit" class="btn btn-default">Gửi</button>
                            </form>
                        </div><!--/login form-->
                    </div>
                </div>
            </div>
        </section><!--/form-->
        

    @endsection