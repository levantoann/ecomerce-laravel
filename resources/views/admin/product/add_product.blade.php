@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm sản phẩm
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
                                <form role="form" action="{{route('save-product')}}" method="post" enctype="multipart/form-data" id="addForm">
                                    {{ csrf_field()}}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên sản phẩm</label>
                                        <input type="text" name="product_name" class="form-control" onkeyup="ChangeToSlug();" id="title" placeholder="Tên sản phẩm">
                                        <label class="error" for="product_name"></label> <!-- Thêm label để chứa thông báo lỗi -->
                                    </div>

                                    <div class="form-group">
                                    <label for="exampleInputEmail1">Slug sản phẩm</label>
                                    <input type="text" name="slug_product" class="form-control" id="slug" placeholder="Tên sản phẩm">
                                </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail2">Giá sản phẩm</label>
                                        <input type="text" name="product_price" class="form-control" id="exampleInputEmail2" placeholder="Giá sản phẩm">
                                        <label class="error" for="product_price"></label> <!-- Thêm label để chứa thông báo lỗi -->
                                    </div>

                                    <div class="form-group">
                                        <label for="product_image">Hình ảnh sản phẩm</label>
                                        <input type="file" name="product_image" class="form-control" id="product_image">
                                        <label class="error" for="product_image"></label> <!-- Thêm label để chứa thông báo lỗi -->
                                    </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea name="product_desc" style="resize:none" rows="3" type="text" class="form-control" id="ckeditor1" placeholder="Mô tả sản phẩm"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                    <textarea name="product_content" style="resize:none" rows="3" type="text" class="form-control" id="exampleInputPassword1" placeholder="Nội dung sản phẩm"></textarea>
                                </div>
                                
                                <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                    <select name="product_cate" class="form-control input-sm m-bot15">
                                        @foreach ($cate_product as $key => $cate )
                                        <option value="{{($cate->category_id)}}">{{($cate->category_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                    <select name="product_brand" class="form-control input-sm m-bot15">
                                        @foreach ($brand_product as $key => $brand )
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Trạng thái sản phẩm</label>
                                    <select name="product_status" class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển Thị</option>
                                    </select>
                                </div>
                                <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
