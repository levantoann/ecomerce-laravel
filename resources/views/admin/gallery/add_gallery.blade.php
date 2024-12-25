@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm thư viện ảnh
                        </header>
                        <div class="panel-body">
                        <?php 
                                $message = Session::get("message");
                                if ($message) { 
                                    echo '<span class="text-alert">'.$message.'</span>';
                                    Session::put("message",  null);
                                }
                            ?>

                            <form action="{{'/insert-gallery/'.$pro_id}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-3" align="right">

                                </div>

                                <div class="col-md-6">
                                    <input type="file" class="form-control" id="file" name="file[]" accept="image/*" multiple>
                                    <span id="error_gallery"></span>
                                </div>

                                <div class="col-md-3">
                                <input type="submit" name="upload" name="taianh" value="Tải ảnh" class="btn btn-success">
                                </div>
                            </form>
                            <input type="hidden" value="{{$pro_id}}" name="pro_id" class="pro_id">
                                <div id="gallery_load">
                                    <form action="">
                                        @csrf
                                        <table class="table table-hover">
                                       
                                        </table>
                                    </form>
                                </div>
                        </div>
                    </section>

            </div>
            </div>
@endsection
