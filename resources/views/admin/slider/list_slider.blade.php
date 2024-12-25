@extends('admin.admin_layout')
@section('admin_content')

<div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê banner
    </div>
    <div class="table-responsive">
    <?php 
		$message = Session::get("message");
		if ($message) { 
			echo '<span class="text-alert">'.$message.'</span>';
			Session::put("message",  null);
		}
	?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Tên slide</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Tình trạng</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($all_slide as $key => $slide)
          
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$slide->slider_name}}</td>
            <td><img src="uploads/slider/{{$slide->slider_image}}" alt="" style="width: 500px;height: 200px;"></td>
            <td>{{$slide->slider_desc}}</td>
            <td><span class="text-ellipsis">
              <?php 
                if($slide->slider_status==0){
                  
              ?>
                 <a href="{{URL::to('/inactive-slider/'.$slide->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down"></span></a>
                 <?php 

                 } else {
                  ?>
                  <a href="{{URL::to('/unactive-slider/'.$slide->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"></span></a>
                  <?php
                 }
                 ?>

            </span></td>
            <td>
                <a href="{{URL::to('/delete-slider/'.$slide->slider_id)}}" onclick="return confirm('Bạn có chắc muốn xóa thương hiệu này không?')" class="active styling-edit" ui-toggle-class="">
              <i class="fa fa-times text-danger text"></i>
                </a>
            </td>
          </tr>
          @endforeach
      
        </tbody>
      </table>
    </div>
  </div>

@endsection
