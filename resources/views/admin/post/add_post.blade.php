@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm bài viết
                        </header>
                        <div class="panel-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <?php 
                                $message = Session::get("message");
                                if ($message) { 
                                    echo '<span class="text-alert">'.$message.'</span>';
                                    Session::put("message",  null);
                                }
                            ?>
                            <div class="position-center">
                                <form role="form" action="{{route('save-post')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên bài viết</label>
                                    <input type="text" data-validation="length" data-validation-length="min10" data-validation-error-msg="Vui lòng điền hơn 10 ký tự"
                                    value="{{ old('post_title') }}" name="post_title" class="form-control" onkeyup="ChangeToSlug();" id="title" placeholder="Tên bài viết">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug bài viết</label>
                                    <input type="text" name="post_slug" class="form-control" id="slug" placeholder="Tên bài viết">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả bài viết</label>
                                    <textarea name="post_desc" id="ckeditor" style="resize:none" rows="8" type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả bài viết"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung bài viết</label>
                                    <textarea name="post_content" id="ckeditor1" style="resize:none" rows="8" type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả bài viết"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Meta từ khóa</label>
                                    <textarea data-validation="length" data-validation-length="min10" data-validation-error-msg="Vui lòng điền hơn 10 ký tự" name="post_meta_keyword" style="resize:none" rows="8" type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả bài viết"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Meta nội dung</label>
                                    <textarea data-validation="length" data-validation-length="min10" data-validation-error-msg="Vui lòng điền hơn 10 ký tự"
                                     name="post_meta_desc" style="resize:none" rows="8" type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả bài viết"></textarea>
                                </div>
                                <div class="form-group">
                                        <label for="post_image">Hình ảnh bài viết</label>
                                        <input type="file" name="post_image" class="form-control" id="product_image">
                                        <label class="error" for="post_image"></label> <!-- Thêm label để chứa thông báo lỗi -->
                                    </div>
                                    <div class="form-group">
                                    <label for="exampleInputPassword1">Danh mục bài viết</label>
                                    <select name="cate_post_id" class="form-control input-sm m-bot15">
                                        @foreach ($cate_post as $key => $cate)
                                        
                                        <option value="{{$cate->cate_post_id}}">{{$cate->cate_post_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Trạng thái bài viết</label>
                                    <select name="post_status" class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiển Thị</option>
                                    </select>
                                </div>
                                <button type="submit" name="add_brand_product" class="btn btn-info">Thêm</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
