@extends('admin.admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm vận chuyển
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
                                <form role="form" action="{{route('insert-delivery')}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="">Chọn tỉnh thành phố</label>
                                    <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                        <option value="0">----Chọn thành phố----</option>
                                        @foreach ($city as $key => $ci )
                                        
                                        <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Chọn quận huyện</label>
                                    <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                        <option value="0">----Chọn quận huyện----</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Chọn xã</label>
                                    <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                        <option value="0">----Chọn xã phường----</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Phí vận chuyển</label>
                                    <input type="text" name="fee_ship" class="form-control fee_ship">
                                </div>
                                <button type="button" name="add_delivery" class="btn btn-info add_delivery">Thêm phí vận chuyển</button>
                            </form>
                            </div>

                        </div>
                        <div id="load_delivery">
                            
                        </div>
                    </section>

            </div>
            </div>
@endsection
