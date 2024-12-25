@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật thương hiệu sản phẩm
                        </header>
                        <?php 
                                $message = Session::get("message");
                                if ($message) { 
                                    echo '<span class="text-alert">'.$message.'</span>';
                                    Session::put("message",  null);
                                }
                            ?>
                        <div class="panel-body">
                            <div class="position-center">
                                @foreach ($edit_brand_product as $key => $edit_value )
                                
                                <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="post">
                                    {{ csrf_field()}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text" name="brand_product_name" onkeyup="ChangeToSlug();" value="{{$edit_value->brand_name}}" class="form-control" id="title" placeholder="Tên thương hiệu">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug thương hiệu</label>
                                    <input type="text" name="slug_brand_product" value="{{$edit_value->slug_brand_product}}" class="form-control" id="slug" placeholder="Tên thương hiệu">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                    <textarea name="brand_product_desc"  style="resize:none" rows="22" type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả thương hiệu">{{$edit_value->brand_desc}}</textarea>
                                </div>
                                <button type="submit" name="update_brand_product" class="btn btn-info" >Cập nhật</button>
                            </form>
                                @endforeach
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
