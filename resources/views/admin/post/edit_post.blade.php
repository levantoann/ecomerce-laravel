@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật bài viết
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
                            <form role="form" action="{{ route('update-post', ['post_id' => $post->post_id]) }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục bài viết</label>
                                    <input type="text" value="{{$post->post_title}}" name="post_title" class="form-control" onkeyup="ChangeToSlug();" id="title" placeholder="Tên danh mục bài viết">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug danh mục bài viết</label>
                                    <input type="text" value="{{$post->post_slug}}"  name="post_slug" class="form-control" id="slug" placeholder="Tên danh mục bài viết">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tóm tắt bài viết</label>
                                    <textarea name="post_desc" style="resize:none" rows="8" type="text" class="form-control" id="ckeditor" placeholder="Mô tả danh mục">{{$post->post_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung bài viết</label>
                                    <textarea name="post_content" style="resize:none" rows="8" type="text" class="form-control" id="ckeditor1" placeholder="Mô tả danh mục">{{$post->post_content}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta từ khóa</label>
                                    <input type="text" value="{{$post->post_meta_keyword}}"  name="post_meta_keyword" class="form-control" id="slug" placeholder="Tên danh mục bài viết">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Meta nội dung</label>
                                    <input type="text" value="{{$post->post_meta_desc}}"  name="post_meta_desc" class="form-control" id="slug" placeholder="Tên danh mục bài viết">
                                </div>

                                <div class="form-group">
                                        <label for="post_image">Hình ảnh bài viết</label>
                                        <input type="file" name="post_image" class="form-control" id="product_image">
                                        <img src="{{asset('uploads/post/'.$post->post_image)}}" height="100" width="100" alt="">
                                    </div>

                                    <div class="form-group">
                                    <label for="exampleInputPassword1">Danh mục bài viết</label>
                                    <select name="cate_post_id" class="form-control input-sm m-bot15">
                                        @foreach ($cate_post as $key => $cate)
                                        
                                        <option {{$post->cate_post_id==$cate->cate_post_id ? 'selected' : ''}} value="{{$cate->cate_post_id}}">{{$cate->cate_post_name}}</option>
                                        @endforeach
                                    </select>


                                <div class="form-group">
                                <label for="exampleInputPassword1">Tình trạng</label>
                                    <select name="post_status" class="form-control input-sm m-bot15">
                                        @if ($post->post_status==1)
                                        
                                        <option selected value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                        @else
                                        <option value="1">Hiển thị</option>
                                        <option selected  value="0">Ẩn</option>
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" name="update_post" class="btn btn-info">Cập nhật</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
