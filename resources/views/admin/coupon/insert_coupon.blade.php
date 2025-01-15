@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm mã giảm giá sản phẩm
                        </header>
                        <div class="panel-body">
                        <?php 
                                $message = Session::get("message");
                                if ($message) { 
                                    echo '<span class="text-alert">'.$message.'</span>';
                                    Session::put("message",  null);
                                }
                            ?>
                            <div class="position-center">
                                <form role="form" action="{{route('insert-coupon-code')}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                    <input type="text" name="coupon_name" class="form-control" placeholder="Tên mã giảm giá">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày bắt đầu giảm giá</label>
                                    <input type="text" name="coupon_date_start" class="form-control" id="start_coupon" placeholder="Ngày bắt đầu giảm giá">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày kết thúc giảm giá</label>
                                    <input type="text" name="coupon_date_end" class="form-control" id="end_coupon" placeholder="Ngày kết thúc giảm giá">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mã giảm giá</label>
                                    <input type="text" name="coupon_code" class="form-control"  placeholder="Tên mã giảm giá">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số lượng mã giảm giá</label>
                                    <input type="text" name="coupon_time" class="form-control" id="slug" placeholder="Tên mã giảm giá">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tính năng mã giảm giá</label>
                                    <select name="coupon_condition" class="form-control input-sm m-bot15">
                                        <option value="0">----Chọn----</option>
                                        <option value="1">Giảm theo phần trăm</option>
                                        <option value="2">Giảm theo tiền</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nhập số $ hoặc tiền giảm</label>
                                    <input type="text" name="coupon_number" class="form-control" id="slug" placeholder="Tên mã giảm giá">
                                </div>
                                <button type="submit" name="add_coupon" class="btn btn-info">Thêm mã</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
