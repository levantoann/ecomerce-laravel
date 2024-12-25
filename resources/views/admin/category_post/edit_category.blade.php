@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật danh mục bài viết
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
                            <form role="form" action="{{ route('update-category-post', ['cate_id' => $category_post->cate_post_id]) }}" method="post">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục bài viết</label>
                                    <input type="text" value="{{$category_post->cate_post_name}}" name="cate_post_name" class="form-control" onkeyup="ChangeToSlug();" id="title" placeholder="Tên danh mục bài viết">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug danh mục bài viết</label>
                                    <input type="text" value="{{$category_post->cate_post_slug}}"  name="cate_post_slug" class="form-control" id="slug" placeholder="Tên danh mục bài viết">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả danh mục bài viết</label>
                                    <textarea name="cate_post_desc" style="resize:none" rows="22" type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$category_post->cate_post_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                <label for="exampleInputPassword1">Tình trạng</label>
                                    <select name="cate_post_status" class="form-control input-sm m-bot15">
                                        @if ($category_post->cate_post_status==1)
                                        
                                        <option selected value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                        @else
                                        <option value="1">Hiển thị</option>
                                        <option selected  value="0">Ẩn</option>
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" name="add_post_cate" class="btn btn-info">Cập nhật</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
