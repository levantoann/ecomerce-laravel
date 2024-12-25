@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm thông tin liên hệ website
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
                                
                            @foreach ($contact as $key => $conn)
                            <form role="form" action="{{ route('update-info', ['info_id' => $conn->info_id]) }}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field()}}
                                    <div class="form-group">
                                    <label for="exampleInputPassword1">Thông tin liên hệ</label>
                                    <textarea style="resize: none;" id="ckeditor" rows="8" name="info_contact"type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả thương hiệu">{{$conn->info_contact}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Bản đồ</label>
                                    <textarea style="resize: none;" rows="8" name="info_map"type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả thương hiệu">{{$conn->info_map}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hình ảnh</label>
                                    <input name="info_image" type="file" class="form-control" id="exampleInputPassword1" placeholder="Mô tả thương hiệu"></input>
                                    <img src="{{asset('uploads/info/'.$conn->info_image)}}" alt="" style="width:100px;height:100px">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Fange</label>
                                    <textarea style="resize: none;" rows="8" name="info_fange"type="text" class="form-control" id="exampleInputPassword1" placeholder="Mô tả thương hiệu">{{$conn->info_fange}}</textarea>
                                </div>
                                
                                <button type="submit" name="add_info" class="btn btn-info">Thêm</button>
                            </form>
                                    @endforeach
                               
                            </div>

                        </div>
                    </section>

            </div>
            </div>
@endsection
