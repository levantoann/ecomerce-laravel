@extends('admin.admin_layout')
@section('admin_content')

<div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê comment
    </div>
    <div id="notify_comment"></div>
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
            <th>Duỵệt</th>
            <th>Tên người dùng</th>
            <th>Trả lời bình luận</th>
            <th>Bình luận</th>
            <th>Ngày gửi</th>
            <th>Sản phẩm</th>
            <th>Quản lý</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($all_comment as $key => $comm)
          
          <tr>
            <td>
            @if ($comm->comment_status==1)
            <input  type="button" data-comment_status="0" class="btn btn-xs btn-danger comment_duyet_btn" data-comment_id="{{$comm->comment_id}}" id="{{$comm->comment_id}}" value="Bỏ duyệt">
        @else
            <input type="button" data-comment_status="1" class="btn btn-xs btn-primary comment_duyet_btn"  data-comment_id="{{$comm->comment_id}}" id="{{$comm->comment_id}}" value="Duyệt">
            @endif    
        </td>
        <td>{{$comm->comment_name}}</td>
        <td>{{$comm->comment}}
        <style>
            ul.list_rep li {
                list-style-type: decimal;
                color: blue;
                margin: 5px 40px;
            }
        </style>
        <ul class="list_rep">
           <b>Trả lời:</b> 
            @foreach ($comment_rep as $key => $comm_reply)
            @if ($comm_reply->comment_parent_comment==$comm->comment_id)
                <li>{{$comm_reply->comment}}</li>
            @endif
            @endforeach
        </ul>
        @if ($comm->comment_status==1)
        <br><textarea rows="5" class="form-control reply_comment_{{$comm->comment_id}}" id=""></textarea>
        <br><button class="btn btn-default btn-sm btn-reply-comment" data-comment_id="{{$comm->comment_id}}" data-product_id="{{$comm->comment_id}}">Trả lời</button>
        @endif
        </td>
        <td>{{$comm->comment_date}}</td>
            <td><a target="_blank" href="{{('/chi-tiet-san-pham/'.$comm->product->slug_product)}}">{{$comm->product->product_name}}</a></td>
            <td>
              <a href="{{URL::to('/edit-comment/'.$comm->comment_id)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-pencil-square-o text-success text-active"></i>
              </a>
                <a href="{{URL::to('/delete-comment/'.$comm->comment_id)}}" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" class="active styling-edit" ui-toggle-class="">
              <i class="fa fa-times text-danger text"></i>
                </a>
            </td>
          </tr>
          @endforeach
      
        </tbody>
      </table>

      <!-- <form action="{{url('import-csv-product')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <input type="file" name="file" accept=".xlsx"><br>
       <input type="submit" value="Import file Excel" name="import_csv" class="btn btn-warning">
        </form>
       <form action="{{url('export-csv-product')}}" method="POST">
          @csrf
       <input type="submit" value="Export file Excel" name="export_csv" class="btn btn-success">
      </form> -->
    </div>
    <!-- <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer> -->
  </div>

@endsection
