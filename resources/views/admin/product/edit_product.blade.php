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
                            @foreach ($edit_product as $key => $pro )
                                <form role="form" action="{{URL::to('/update-product/'.$pro->product_id)}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="product_name" class="form-control" onkeyup="ChangeToSlug();" id="title" placeholder="Tên sản phẩm" value="{{$pro->product_name}}">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug sản phẩm</label>
                                    <input type="text" name="slug_product" class="form-control" id="slug" placeholder="Tên sản phẩm" value="{{$pro->slug_product}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng sản phẩm</label>
                                    <input type="text" name="product_quantity" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm" value="{{$pro->product_quantity}}">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá gốc</label>
                                    <input type="text"  name="price_cost" class="form-control price_format" id="exampleInputEmail1" placeholder="Giá sản phẩm" value="{{$pro->price_cost}}">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" placeholder="Giá sản phẩm" value="{{$pro->product_price}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hình ảnh sản phẩm</label>
                                    <input type="file" name="product_image" class="form-control">
                                    <img src="{{URL::to('uploads/product/'.$pro->product_image)}}" alt="" style="width:100px;height:100px">
                                </div>

                                <div class="form-group">
                                        <label for="product_image">Tài liệu</label>
                                        <input type="file" name="document" class="form-control" id="document">
                                        @if ($pro->product_file)
                                        <p><a href="{{asset('uploads/document/'.$pro->product_file)}}">{{$pro->product_file}} </a>
                                        <button type="button" data-document_id="{{$pro->product_id}}" class="btn btn-sm btn-danger btn-delete-document"><i class="fa fa-times"></i></button>
                                        </p>
                                        @else
                                        <p>Không có file</p>
                                        @endif
                                    </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea name="product_desc" id="ckeditor2" style="resize:none" rows="3" type="text" class="form-control" id="exampleInputPassword1">{{$pro->product_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                    <textarea name="product_content" id="ckeditor3" style="resize:none" rows="3" type="text" class="form-control" id="exampleInputPassword1">{{$pro->product_content}}</textarea>
                                </div>
                                
                                <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                    <select name="product_cate" class="form-control input-sm m-bot15">
                                        @foreach ($cate_product as $key => $cate )
                                        @if ($cate->category_id==$pro->category_id)
                                        <option selected value="{{($cate->category_id)}}">{{($cate->category_name)}}</option>
                                        @else
                                        <option value="{{($cate->category_id)}}">{{($cate->category_name)}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tags sản phẩm</label>
                                    <input type="text" name="product_tags" class="form-control" data-role="tagsinput" value="{{$pro->product_tags}}">
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                    <select name="product_brand" class="form-control input-sm m-bot15">
                                        @foreach ($brand_product as $key => $brand )
                                        @if ($brand->brand_id==$pro->brand_id)
                                        <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @else
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endif
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
                            @endforeach
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
