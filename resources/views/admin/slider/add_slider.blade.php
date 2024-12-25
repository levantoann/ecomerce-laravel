@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm banner
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
                                <form role="form" action="{{route('insert-slider')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên slide</label>
                                    <input type="text" name="slider_name" class="form-control"  placeholder="Tên thương hiệu">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="slider_image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả slide</label>
                                    <textarea name="slider_desc" style="resize:none" rows="22" type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả thương hiệu"></textarea>
                                </div>
                                <div class="form-group">
                                    <select name="slider_status" class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn slide</option>
                                        <option value="1">Hiển Thị slide</option>
                                    </select>
                                </div>
                                <button type="submit" name="add_slider" class="btn btn-info">Thêm slider</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
