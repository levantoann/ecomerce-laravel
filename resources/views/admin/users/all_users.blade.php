@extends('admin.admin_layout')
@section('admin_content')

<div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê user
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>                
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
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
            <th>Tên user</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
            <th>Author</th>
            <th>Admin</th>
            <th>User</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($admin as $key => $user)
          <form action="{{url('/assign-roles')}}" method="POST">
            @csrf
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$user->admin_name}}</td>
            <td>{{$user->admin_email}}
            <input type="hidden" name="admin_email" value="{{ $user->admin_email }}">
            <input type="hidden" name="admin_id" value="{{ $user->admin_id }}">
            </td>
            <td>{{$user->admin_phone}}</td>
            <td>{{$user->admin_password}}</td>
            <td><input type="checkbox" name="author_role" {{$user->hasRole('author') ? 'checked' : ''}}></td>
            <td><input type="checkbox" name="admin_role" {{$user->hasRole('admin') ? 'checked' : ''}}></td>
            <td><input type="checkbox" name="user_role" {{$user->hasRole('user') ? 'checked' : ''}}></td>
            <td>
                <p><input type="submit" value="Trao quyền" class="btn btn-sm btn-default"></p>
                <p style="margin:5px 0px"><a class="btn btn-sm btn-danger" href="{{url('/delete-user-roles/'.$user->admin_id)}}">Xóa user</a></p>
                <p style="margin:5px 0px"><a class="btn btn-sm btn-success" href="{{url('/impersonate/'.$user->admin_id)}}">Đổi user</a></p>
        </td>
            </tr>
            </form>
          @endforeach
      
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
  <div class="row">
    <!-- Hiển thị thông tin số lượng bản ghi hiện tại -->
    <div class="col-sm-5 text-center">
      <small class="text-muted inline m-t-sm m-b-sm">
        Showing {{ $admin->firstItem() }}-{{ $admin->lastItem() }} of {{ $admin->total() }} items
      </small>
    </div>

    <!-- Phân trang -->
    <div class="col-sm-7 text-right text-center-xs">
      <ul class="pagination pagination-sm m-t-none m-b-none">
        <!-- Trang trước -->
        @if ($admin->onFirstPage())
          <li class="disabled"><span><i class="fa fa-chevron-left"></i></span></li>
        @else
          <li><a href="{{ $admin->previousPageUrl() }}"><i class="fa fa-chevron-left"></i></a></li>
        @endif
        
        <!-- Hiển thị các số trang -->
        @foreach ($admin->getUrlRange(1, $admin->lastPage()) as $page => $url)
          <li class="{{ ($admin->currentPage() == $page) ? 'active' : '' }}">
            <a href="{{ $url }}">{{ $page }}</a>
          </li>
        @endforeach
        
        <!-- Trang sau -->
        @if ($admin->hasMorePages())
          <li><a href="{{ $admin->nextPageUrl() }}"><i class="fa fa-chevron-right"></i></a></li>
        @else
          <li class="disabled"><span><i class="fa fa-chevron-right"></i></span></li>
        @endif
      </ul>
    </div>
  </div>
</footer>

  </div>

@endsection
