<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
<title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Home :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet"> 
<link rel="stylesheet" href="{{asset('backend/css/morris.css')}}" type="text/css"/>
<!-- calendar -->
<link rel="stylesheet" href="{{asset('backend/css/monthly.css')}}">
<link rel="stylesheet" href="{{asset('backend/css/dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/css/bootstrap-tagsinput.css')}}">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<meta name="csrf-token" content="{{csrf_token()}}">

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="{{asset('backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('backend/js/raphael-min.js')}}"></script>
<script src="{{asset('backend/js/dataTables.min.js')}}"></script>
<script src="{{asset('backend/js/morris.js')}}"></script>
<script src="{{asset('backend/js/vlite.js')}}"></script>


<script type="text/javascript">
   $(document).ready(function(){
       $('.update_quantity_order').click(function(){
           var order_product_id = $(this).data('product_id'); // Lấy product_id từ data attribute
           var order_qty = $('.order_qty_'+order_product_id).val(); // Lấy số lượng từ input
           var order_code = $('.order_code').val(); // Lấy order_code
           var _token = $('input[name="_token"]').val(); // CSRF Token để bảo mật

           $.ajax({
               url: '{{ url('/update-qty') }}', // URL xử lý yêu cầu
               method: 'POST',
               data: {  
                   _token: _token,
                   order_product_id: order_product_id,
                   order_qty: order_qty,
                   order_code: order_code
               },
               success: function (data) {
                   alert('Cập nhật số lượng thành công'); // Hiển thị thông báo khi thành công
               },
               error: function (xhr, status, error) {
                   console.log('Có lỗi xảy ra: ' + xhr.responseText); // Báo lỗi nếu có
               }
           });
       });
   });
</script>

<script type="text/javascript">
   $(document).ready(function(){
       $('.order_details').change(function(){
           var order_status = $(this).val();  // Lấy trạng thái đơn hàng
           var order_id = $(this).children(":selected").attr("id");  // Lấy ID đơn hàng
           var _token = $('input[name="_token"]').val();  // Lấy CSRF Token

           // Mảng chứa số lượng sản phẩm
           var quantity = [];
           $("input[name='product_sales_quantity']").each(function(){
               quantity.push($(this).val());
           });

           // Mảng chứa ID sản phẩm
           var order_product_id = [];
           $("input[name='order_product_id']").each(function(){
               order_product_id.push($(this).val());
           });

           // Biến để theo dõi số lượng sản phẩm không đủ
           var j = 0;

           // Kiểm tra số lượng sản phẩm so với số lượng tồn kho
           for (var i = 0; i < order_product_id.length; i++) {
               var order_qty = $('.order_qty_' + order_product_id[i]).val();  // Số lượng sản phẩm đã chọn
               var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();  // Số lượng tồn kho

               // Nếu số lượng sản phẩm lớn hơn tồn kho, đánh dấu lỗi
               if (parseInt(order_qty) > parseInt(order_qty_storage)) {
                   j = j + 1;  // Tăng biến lỗi
                   if (j == 1) {
                       alert('Số lượng sản phẩm không đủ.');
                   }
                   $('.color_qty_' + order_product_id[i]).css('background', 'red');  // Tô màu đỏ cho sản phẩm không đủ
               }
           }

           // Nếu không có lỗi, gửi yêu cầu AJAX để cập nhật đơn hàng
           if (j == 0) {
               $.ajax({
                   url: '{{ url('/update-order-qty') }}',
                   method: 'POST',
                   data: {  
                       _token: _token,
                       order_status: order_status,
                       order_id: order_id,
                       quantity: quantity,
                       order_product_id: order_product_id
                   },
                   success: function (data) {
                       alert('Cập nhật tình trạng đơn hàng thành công.');
                       console.log(data)
                    //    location.reload();
                   },
                   error: function(xhr, status, error) {
                       alert('Có lỗi xảy ra trong quá trình cập nhật.');
                       console.log(xhr.responseText);
                   }
               });
           }
       });
   });
</script>

<script type="text/javascript">
    list_nut();
    function delete_icons(id) {
        $.ajax({
            url: '{{ url('/delete-icons') }}',
            method: 'GET',
            data:{id:id},
            success: function (data) {
               list_nut();
            },
        });
    }
    function list_nut() {
        $.ajax({
            url: '{{ url('/list-nut') }}',
            method: 'GET',
            success: function (data) {
               $('#list_nut').html(data);
            },
        });
    }
   $('.add-nut').click(function () {
    console.log('Button clicked!'); // Kiểm tra sự kiện
    var name = $('#name').val();
    var link = $('#link').val();
    var image = $('#image_nut')[0].files;

    console.log({ name, link, image }); // Kiểm tra giá trị đầu vào

    var form_data = new FormData();
    form_data.append('name', name);
    form_data.append('link', link);
    form_data.append('image', image);

    $.ajax({
        url: '{{ url('/add-nut') }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: false,
        cache: false,
        processData: false,
        data: form_data,
        success: function (data) {
            console.log('Success:', data); // Kiểm tra phản hồi từ server
            alert('Thêm nút thành công');
            list_nut();
        },
        error: function (xhr) {
            console.error('Error:', xhr.responseText); // Kiểm tra lỗi nếu có
            alert('Có lỗi xảy ra!');
        }
    });
});

</script>


<script type="text/javascript">
   $(document).ready(function () {
    
    fetch_delivery();

    function fetch_delivery(){
        var _token = $('input[name="_token"]').val(); // CSRF token
        $.ajax({
            url: '{{ url('/select-feeship') }}',
            method: 'POST',
            data: {  _token: _token},
            success: function (data) {
               $('#load_delivery').html(data);
            },
        });
    }
    $(document).on('blur','.fee_feeship_edit',function () {
        var feeship_id = $(this).data('feeship_id');
        var fee_value = $(this).text();
        var _token = $('input[name="_token"]').val(); // CSRF token
        $.ajax({
            url: '{{ url('/update-delivery') }}',
            method: 'POST',
            data: { feeship_id:feeship_id,
                fee_value:fee_value,_token: _token },
            success: function (data) {
                fetch_delivery();
            },
        });
    })
    $('.add_delivery').click(function() {
        var city = $('.city').val();
        var province = $('.province').val();
        var wards = $('.wards').val();
        var fee_ship = $('.fee_ship').val();
        var _token = $('input[name="_token"]').val(); // CSRF token
        $.ajax({
            url: '{{ url('/insert-delivery') }}',
            method: 'POST',
            data: { city: city, province: province,wards:wards, _token: _token,fee_ship:fee_ship },
            success: function (data) {
                fetch_delivery();
            },
        });
    })
    $('.choose').on('change', function () {
        var action = $(this).attr('id'); // city hoặc province
        var ma_id = $(this).val(); // Lấy giá trị id được chọn
        var _token = $('input[name="_token"]').val(); // CSRF token
        var result = '';

        if (action == 'city') {
            result = 'province';
        } else if (action == 'province') {
            result = 'wards';
        }

        $.ajax({
            url: '{{ url('/select-delivery') }}',
            method: 'POST',
            data: { action: action, ma_id: ma_id, _token: _token },
            success: function (data) {
                $('#' + result).html(data); // Đổ dữ liệu vào select tương ứng
            },
        });
    });
});

 </script>
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="index.html" class="logo">
        VISITORS
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{asset('backend/images/2.png')}}">
                <span class="username">
					<?php 
						$name = Auth::user()->admin_name;
						if ($name) { 
							echo $name;
						}
					?>
				</span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="{{url('/logout-auth')}}"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{route('dashboard')}}">
                        <i class="fa fa-book"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>

                <li>
                    <a class="active" href="{{route('read-data')}}">
                        <i class="fa fa-book"></i>
                        <span>Google drive</span>
                    </a>
                </li>

                <li>
                    <a class="active" href="{{route('information')}}">
                        <i class="fa fa-book"></i>
                        <span>Thông tin website</span>
                    </a>
                </li>

                 
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Banner</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('manage-banner')}}">Quản lý banner</a></li>
						<li><a href="{{route('add-slider')}}">Thêm banner</a></li>
                    </ul>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('add-category-product')}}">Thêm danh mục sản phẩm</a></li>
						<li><a href="{{route('all-category-product')}}">Liệt kê danh mục sản phẩm</a></li>
                    </ul>
                </li>
                

				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Thương hiệu sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('add-brand-product')}}">Thêm thương hiệu sản phẩm</a></li>
						<li><a href="{{route('all-brand-product')}}">Liệt kê thương hiệu sản phẩm</a></li>
                    </ul>
                </li>

                
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục bài viết</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('add-category-post')}}">Thêm bài viết</a></li>
						<li><a href="{{route('all-category-post')}}">Liệt kê bài viết</a></li>
                    </ul>
                </li>		


				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('add-product')}}">Thêm sản phẩm</a></li>
						<li><a href="{{route('all-product')}}">Liệt kê sản phẩm</a></li>
                    </ul>
                </li>		

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Bài viết</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('add-post')}}">Thêm bài viết</a></li>
						<li><a href="{{route('all-post')}}">Liệt kê bài viết</a></li>
                    </ul>
                </li>		

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Video</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('video')}}">Thêm video</a></li>
                    </ul>
                </li>		


                @impersonate
                <li>
                    <a class="active" href="{{route('impersonate-destroy')}}">
                        <i class="fa fa-book"></i>
                        <span>Stop chuyển quyền</span>
                    </a>
                </li>
                @endimpersonate
				<li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('manage-order')}}">Quản lý đơn hàng</a></li>
                    </ul>
                    
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Mã giảm giá</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('insert-coupon')}}">Quản lý mã giảm giá</a></li>
                    </ul>
                    <ul class="sub">
						<li><a href="{{route('list-coupon')}}">Liệt kê mã giảm giá</a></li>
                    </ul>
                    
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Bình luận</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('list-comment')}}">Liệt kê bình luận</a></li>
                    </ul>
                    
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Vận chuyển</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('delivery')}}">Quản lý vận chuyển</a></li>
                    </ul>
                    
                </li>

                        @hasrole(['admin','author'])
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{route('add-users')}}">Thêm Users</a></li>
						<li><a href="{{route('users')}}">Liệt kê Users</a></li>
                    </ul>
                    
                </li>
                @endhasrole
                
            </ul>            
		</div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
        @yield('admin_content')
</section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('backend/js/bootstrap.js')}}"></script>
<script src="{{asset('backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('backend/js/scripts.js')}}"></script>
<script src="{{asset('backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('backend/js/simple.money.format.js')}}"></script>

<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('backend/js/jquery.scrollTo.js')}}"></script>
<script src="{{asset('backend/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.1/jquery-ui.min.js" integrity="sha512-MSOo1aY+3pXCOCdGAYoBZ6YGI0aragoQsg1mKKBHXCYPIWxamwOE7Drh+N5CPgGI5SA9IEKJiPjdfqWFWmZtRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $('.btn-delete-document').click(function(){
        var product_id = $(this).data('document_id');
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:"{{url('/delete-document')}}", // Đường dẫn API
            method:"POST",
            data:{product_id:product_id,_token:_token},
            success:function(data){
                alert('Xóa file thành công');
                location.reload();
            }
        });
       

    })
    </script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.price_format').simpleMoneyFormat();

    })
    </script>
<script>
    $(document).ready(function(){
        $('#category_order').sortable({
            placeholder: 'ui-state-highlight',
            update:function(event, ui)
            {
                var page_id_array = new Array();
                var _token = $('input[name="_token"]').val();
                $('#category_order tr').each(function () {
                    page_id_array.push($(this).attr("id"));
                });
                $.ajax({
                url:"{{url('/arrange-category')}}", // Đường dẫn API
                method:"POST",
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                }, 
                data:{page_id_array:page_id_array,_token:_token},
                success:function(data){
                   alert(data);
                }
            });
            }
        })
    })
</script>
<script type="text/javascript">
 $('.comment_duyet_btn').click(function(){
    var comment_status = $(this).data('comment_status');
    var comment_id = $(this).data('comment_id');
    var comment_product_id = $(this).attr('id');

    if (comment_status==1) {
        var alert = 'Thay đổi duyệt bình luận thành công'
    }else {
        var alert = 'Thay đổi không duyệt bình luận thành công'
    }
        $.ajax({
            url:"{{url('/allow-comment')}}", // Đường dẫn API
            method:"POST",
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, 
            data:{comment_status:comment_status,comment_id:comment_id,comment_product_id:comment_product_id},
            success:function(data){
                $('#notify_comment').html('<span class="text text-success">'+alert+'</span>');
            }
        });
 })
 $('.btn-reply-comment').click(function(){
     var comment_id = $(this).data('comment_id');
    var comment = $('.reply_comment_'+comment_id).val();
    var comment_product_id = $(this).data('product_id');
    
        var alert = 'Trả lời duyệt bình luận thành công'
    
        $.ajax({
            url:"{{url('/reply-comment')}}", // Đường dẫn API
            method:"POST",
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, 
            data:{comment:comment,comment_id:comment_id,comment_product_id:comment_product_id},
            success:function(data){
                $('.reply_comment'+comment_id).val('');
                $('#notify_comment').html('<span class="text text-success">'+alert+'</span>');
            }
        });
 })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        let table = new DataTable('#myTable');
         $('#myTable').DataTable(); 
         });
</script>


<script type="text/javascript">
     $(document).ready(function(){
    load_video();

    function load_video() {
        var _token = $('input[name="_token"]').val(); // Lấy token CSRF
        $.ajax({
            url:"{{url('/select-video')}}", // Đường dẫn API
            method:"POST",
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, 
            success:function(data){
                $('#video_load').html(data); // Đổ dữ liệu nhận về vào phần tử #gallery_load
            }
        });
    }
    $(document).on('click','.btn-add-video',function(){
        var video_title = $('.video_title').val();
        var video_slug = $('.video_slug').val();
        var video_link = $('.video_link').val();
        var video_desc = $('.video_desc').val();

        var form_data = new FormData();
        form_data.append("file",document.getElementById('file_img_video').files[0]);
            form_data.append("video_title",video_title);
            form_data.append("video_slug",video_slug);
            form_data.append("video_link",video_link);
            form_data.append("video_desc",video_desc);
        $.ajax({
            url:"{{url('/insert-video')}}", // Đường dẫn API
            method:"POST",
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, 
            data:form_data,
            contentType:false,
            cache:false,
            processData:false,
            success:function(data){
                load_video();
                $('#notify').html('<span class="text text-success">Đã thêm video thành công</span>');
            }
        });
    });
    $(document).on('click','.btn-delete-video',function(){
        var video_id = $(this).data('video_id');
        if (confirm('Bạn có muốn xóa video không')) {
            $.ajax({
            url:"{{url('/delete-video')}}", // Đường dẫn API
            method:"POST",headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, 
            data:{video_id:video_id},
            success:function(data){
                load_video();
                $('#notify').html('<span class="text text-success">Xóa video thành công</span>');
            }
        }); 
        }
       
    });
    $(document).on('blur','.video_edit',function(){
        var video_type = $(this).data('video_type');
        var video_id = $(this).data('video_id');
        
        if (video_type=='video_title') {
            var video_edit = $('#'+video_type+'_'+video_id).text();
            var video_check = video_type;
        } else if(video_type=='video_desc') {
            var video_edit = $('#'+video_type+'_'+video_id).text();
            var video_check = video_type;
        }else if(video_type=='video_link') {
            var video_edit = $('#'+video_type+'_'+video_id).text();
            var video_check = video_type;
        }
        else {
            var video_edit = $('#'+video_type+'_'+video_id).text();
            var video_check = video_type;
        }
        $.ajax({
            url:"{{url('/update-video')}}", // Đường dẫn API
            method:"POST",
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }, 
            data:{video_edit:video_edit,video_id:video_id,video_check:video_check},
            success:function(data){
                load_video();
                $('#notify').html('<span class="text text-success">Cập nhật video thành công</span>');
            }
        });
    })

    $(document).on('change','.file_img_video',function(){
            var video_id = $(this).data('video_id');
            var image = document.getElementById('file-video-'+video_id).files[0];

            var form_data = new FormData();

            form_data.append("file",document.getElementById('file-video-'+video_id).files[0]);
            form_data.append("video_id",video_id);
            $.ajax({
            url:"{{url('/update-video-image')}}", // Đường dẫn API
            method:"POST",
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            data:form_data, // Truyền dữ liệu pro_id và CSRF token
            contentType:false,
            cache:false,
            processData:false,
            success:function(form_data){
                load_video();
                $('#notify').html('<span class="text text-success">Cập nhật ảnh video thành công</span>');
            }
        });
           
    });
})
</script>



<script type="text/javascript">
     $(document).ready(function(){
    load_gallery();

    function load_gallery() {
        var pro_id = $('.pro_id').val(); // Lấy giá trị của input có class .pro_id
        var _token = $('input[name="_token"]').val(); // Lấy token CSRF
        $.ajax({
            url:"{{url('/select-gallery')}}", // Đường dẫn API
            method:"POST",
            data:{pro_id:pro_id, _token:_token}, // Truyền dữ liệu pro_id và CSRF token
            success:function(data){
                $('#gallery_load').html(data); // Đổ dữ liệu nhận về vào phần tử #gallery_load
            }
        });
    }
        $('#file').change(function(){
            var error = '';
            var files = $('#file')[0].files;
            if (files.length>5) {
                error+='<p>Bạn chỉ được chọn tối đa 5 ảnh</p>'
            } else if (files.length=='') {
                 error+='<p>Không được bỏ trống ảnh</p>'
            }else if (files.size > 2000000) {
                 error+='<p>File ảnh không được lớn hơn 2mb</p>'
            } if (error=='') {
                
            } else {
                $('#file').val('');
                $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
                return false;
            }
        });

        $(document).on('blur','.edit_gal_name',function(){
            var gal_id = $(this).data('gal_id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val()
            if (confirm) {
                
            }
            $.ajax({
            url:"{{url('/update-gallery-name')}}", // Đường dẫn API
            method:"POST",
            data:{gal_id:gal_id, _token:_token,gal_text:gal_text}, // Truyền dữ liệu pro_id và CSRF token
            success:function(data){
                load_gallery();
                $('#error_gallery').html('<span class="text-danger">Cập nhật tên hình ảnh thành công</span>');
            }
        });
        })
        $(document).on('click','.delete-gallery',function(){
            var gal_id = $(this).data('gal_id');
            
            var _token = $('input[name="_token"]').val()
            if(confirm('Bạn muốn xóa hình này không ?')) {
            $.ajax({
            url:"{{url('/delete-gallery')}}", // Đường dẫn API
            method:"POST",
            data:{gal_id:gal_id, _token:_token}, // Truyền dữ liệu pro_id và CSRF token
            success:function(data){
                load_gallery();
                $('#error_gallery').html('<span class="text-danger">Xóa hình ảnh thành công</span>');
            }
        });
            }
           
    });
    $(document).on('change','.file_image',function(){
            var gal_id = $(this).data('gal_id');
            var image = document.getElementById('file-'+gal_id).files[0];

            var form_data = new FormData();

            form_data.append("file",document.getElementById('file-'+gal_id).files[0]);
            form_data.append("gal_id",gal_id);
            $.ajax({
            url:"{{url('/update-gallery')}}", // Đường dẫn API
            method:"POST",
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            data:form_data, // Truyền dữ liệu pro_id và CSRF token
            contentType:false,
            cache:false,
            processData:false,
            success:function(form_data){
                load_gallery();
                $('#error_gallery').html('<span class="text-danger">Cập nhật hình ảnh thành công</span>');
            }
        });
           
    });

        
});

</script>

<script type="text/javascript">
    $(document).ready(function(){
    $.validate({
        lang: 'vi'
    });
});
</script>
<script type="text/javascript">
$(document).ready(function() {
    $("#addForm").validate({
        rules: {
            product_name: {
                required: true,
                minlength: 3
            },
            product_price: {
                required: true,
                number: true
            },
            product_image: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            },
            // Các quy tắc khác nếu cần
        },
        messages: {
            product_name: {
                required: "Vui lòng nhập tên sản phẩm.",
                minlength: "Làm ơn điền ít nhất 3 ký tự."
            },
            product_price: {
                required: "Vui lòng nhập giá sản phẩm.",
                number: "Vui lòng nhập một số hợp lệ."
            },
            product_image: {
                required: "Hình ảnh sản phẩm là bắt buộc.",
                extension: "Chỉ chấp nhận định dạng jpg, jpeg, png, gif."
            },
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.closest('.form-group').find('label.error')); // Chỉ định nơi hiển thị thông báo lỗi
        },
        submitHandler: function(form) {
            $(form).submit();
        }
    });
});
</script>

<!-- slug -->
 <script type="text/javascript">
	function ChangeToSlug()
{
    var title, slug;
 
    //Lấy text từ thẻ input title 
    title = document.getElementById("title").value;
 
    //Đổi chữ hoa thành chữ thường
    slug = title.toLowerCase();
 
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    //In slug ra textbox có id “slug”
    document.getElementById('slug').value = slug;
}

 </script>


<script type="text/javascript">
    
	CKEDITOR.replace('ckeditor');
	CKEDITOR.replace('ckeditor1');
    CKEDITOR.replace('ckeditor2', {
            filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}" , 
            filebrowserBrowserdUrl: "{{url('file-browser?_token='.csrf_token())}}", 
            filebrowserUploadMethod: 'form' ,
    });

    CKEDITOR.replace('ckeditor3', {
            filebrowserImageUploadUrl: "{{url('uploads-ckeditor?_token='.csrf_token())}}" , 
            filebrowserBrowserdUrl: "{{url('file-browser?_token='.csrf_token())}}", 
            filebrowserUploadMethod: 'form' , 
    });
</script>
<!-- morris JavaScript -->	
<script>
	$(document).ready(function() {
		//BOX BUTTON SHOW AND CLOSE
	   jQuery('.small-graph-box').hover(function() {
		  jQuery(this).find('.box-button').fadeIn('fast');
	   }, function() {
		  jQuery(this).find('.box-button').fadeOut('fast');
	   });
	   jQuery('.small-graph-box .box-close').click(function() {
		  jQuery(this).closest('.small-graph-box').fadeOut(200);
		  return false;
	   });
	   
	    //CHARTS
	    function gd(year, day, month) {
			return new Date(year, month - 1, day).getTime();
		}
		
		graphArea2 = Morris.Area({
			element: 'hero-area',
			padding: 10,
        behaveLikeLine: true,
        gridEnabled: false,
        gridLineColor: '#dddddd',
        axes: true,
        resize: true,
        smooth:true,
        pointSize: 0,
        lineWidth: 0,
        fillOpacity:0.85,
			data: [
				{period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
				{period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
				{period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
				{period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
				{period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
				{period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
				{period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
				{period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
				{period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},
			
			],
			lineColors:['#eb6f6f','#926383','#eb6f6f'],
			xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
			pointSize: 2,
			hideHover: 'auto',
			resize: true
		});
		
	   
	});
	</script>

    <!-- donut chart -->
     <script type="text/javascript">
        $(document).ready(function() {
           var donut = new Morris.Donut({
            
            element: 'donut',
            colors: [
                '#a8328e',
                '#61a1ce',
                '#ce8f61',
                '#f5b942',
                '#4842f5',
            ],
            
            data: [
                { label: 'San pham', value: <?php echo $app_product ?>},
                { label: 'Bai viet', value:  <?php echo $app_post ?> },
                { label: 'Don hang', value:  <?php echo $app_order ?> },
                { label: 'Video', value:  <?php echo $app_video ?> },
                { label: 'Khách hàng', value:  <?php echo $app_customer ?> }
            ]
            
            });
        })
     </script>
<!-- calendar -->
	<script type="text/javascript" src="js/monthly.js"></script>
	<script type="text/javascript">
		$(window).load( function() {

			$('#mycalendar').monthly({
				mode: 'event',
				
			});

			$('#mycalendar2').monthly({
				mode: 'picker',
				target: '#mytarget',
				setWidth: '250px',
				startHidden: true,
				showTrigger: '#mytarget',
				stylePast: true,
				disablePast: true
			});

		switch(window.location.protocol) {
		case 'http:':
		case 'https:':
		// running on a server, should be good.
		break;
		case 'file:':
		alert('Just a heads-up, events will not work when run locally.');
		}

		});
	</script>
	<!-- //calendar -->

    <script>
  $( function() {
    $( "#datepicker" ).datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: ["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6", "Thứ 7","Chủ nhật"],
    });
    $( "#datepicker2" ).datepicker({
        revText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "yy-mm-dd",
        dayNamesMin: ["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6", "Thứ 7","Chủ nhật"],
    });
  } );
  </script>

<script type="text/javascript">
    $(document).ready(function() {
        $( function() {
    $("#start_coupon" ).datepicker({
        prevText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "dd/mm/yy",
        dayNamesMin: ["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6", "Thứ 7","Chủ nhật"],
    });
    $("#end_coupon").datepicker({
        revText: "Tháng trước",
        nextText: "Tháng sau",
        dateFormat: "dd/mm/yy",
        dayNamesMin: ["Thứ 2","Thứ 3","Thứ 4","Thứ 5","Thứ 6", "Thứ 7","Chủ nhật"],
    });
  } );
    })

    </script>
  <script type="text/javascript">
    $(document).ready(function() {
        chart30daysorder();
        var chart = new Morris.Area({
            element: 'myfirstchart',
            lineColors:['#819c79','#fc8710','#FF6541','#A4ADD3','#766B56'],

            pointFillColors: ['#ffffff'],
            pointStrokeColors: ['#black'],
            fillOpacity: 0.3,
            hideHover: 'auto',
            parseTime:false,
            data: [
                { period: '2008', value: 20 },
                { period: '2009', value: 10 },
                { period: '2010', value: 5 },
                { period: '2011', value: 5 },
                { period: '2012', value: 20 }
            ],
            xkey: 'period',
            ykeys: ['order','sales','profit','quantity'],
            behaveLikeLine: true,
            labels: ['đơn hàng','doanh số ','lợi nhuận','số lượng']
            });

           function chart30daysorder(){
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{url('/days-order')}}", // URL của API
                method: "POST",
                dataType: "JSON",
                data:{_token:_token},
                success:function(data){
                    chart.setData(data); 
                }
            });
        }

            $('#btn-dashboard-filter').click(function(){
            var _token = $('input[name="_token"]').val();
            
            var from_date = $('#datepicker').val();
            var to_date = $('#datepicker2').val();

            $.ajax({
                url: "{{url('/filter-by-date')}}",
                method: "POST",
                dataType: "JSON",
                data:{from_date:from_date,to_date:to_date,_token:_token},
                success:function(data){
                    console.log(data);
                    chart.setData(data); 
                }
            })
        })
        $('.dashboard-filter').change(function(){
            var _token = $('input[name="_token"]').val();
            var dashboard_value = $(this).val();

            $.ajax({
                url: "{{url('/dashboard-filter')}}",
                method: "POST",
                dataType: "JSON",
                data:{dashboard_value:dashboard_value,_token:_token},
                success:function(data){
                    console.log(data);
                    chart.setData(data); 
                }
            })
        })
    })
  </script>
  <script type="text/javascript">
 
  </script>
</body>
</html>
