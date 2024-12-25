@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm user
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
                                <form role="form" action="{{route('store-users')}}" method="post">
                                    {{ csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên user</label>
                                        <input type="text" name="admin_name" class="form-control"placeholder="Tên sản user">
                                        <label class="error" for="admin_name"></label> <!-- Thêm label để chứa thông báo lỗi -->
                                    </div>

                                    <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" name="admin_email" class="form-control"  placeholder="Email">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Phone</label>
                                    <input type="text" name="admin_phone" class="form-control" placeholder="Số điện thoại">
                                </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Password</label>
                                        <input type="password" name="admin_password" class="form-control" id="exampleInputEmail2" placeholder="Password">
                                        <label class="error" for="admin_password"></label> <!-- Thêm label để chứa thông báo lỗi -->
                                    </div>
                                
                    
                                <button type="submit" name="add_product" class="btn btn-info">Thêm user</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
