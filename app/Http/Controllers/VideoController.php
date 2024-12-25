<?php

namespace App\Http\Controllers;

use App\Models\CategoryPostModel;
use App\Models\Product;
use App\Models\Silder;
use App\Models\Video;
use Auth;
use DB;
use File;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class VideoController extends Controller
{
    public function AuthLogin() {
        $admin_id = Auth::id();
        if ($admin_id) {
            return Redirect::to("dashboard");
        } else { 
              return Redirect::to("admin")->send();
        }
        }

    public function video() {
        return view('admin.video.list_video');
    }

    public function select_video(Request $request) {
        $video = Video::orderBy('video_id','ASC')->get();
        $video_count = $video->count();
        $output = '
        <form>
                '.csrf_field().'
           <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:20px;">
              <label class="i-checks m-b-none">
                <input type="checkbox"><i></i>
              </label>
            </th>
            <th>Thứ tự</th>
            <th>Tên video</th>
            <th>Slug video</th>
            <th>Hình ảnh video</th>
            <th>Link video</th>
            <th>Mô tả</th>
            <th>Demo video</th>
            <th style="width:30px;">Quản lý video</th>
          </tr>
        </thead>
        <tbody>
                                        
                                        
        ';
        if ($video_count>0) {
            $i = 0;
            foreach($video as $key => $vid){
                $i++;
                $output.= '
               <tr>
               <td></td>
                <td>'.$i.'</td>
                <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_title" class="video_edit" id="video_title_'.$vid->video_id.'">'.$vid->video_title.'</td>
                <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_slug" class="video_edit" id="video_slug_'.$vid->video_id.'">'.$vid->video_slug.'</td>
                <td><img src="'.url('uploads/videos/'.$vid->video_image).'"class="img-thumbnail" width="120px" height="80px" alt="">
                 <input type="file" class="file_img_video" data-video_id="'.$vid->video_id.'" 
                 id="file-video-'.$vid->video_id.'" name="file" accept="image/*" /></td>
                <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_link" class="video_edit" 
                id="video_link_'.$vid->video_id.'">https://www.youtube.be/'.$vid->video_link.'</td>
                <td contenteditable data-video_id="'.$vid->video_id.'" data-video_type="video_desc" class="video_edit" id="video_desc_'.$vid->video_id.'">'.$vid->video_desc.'</td>
                 <td><iframe  
                 width="600" height="200" src="https://www.youtube.com/embed/'.$vid->video_link.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></td>
                <td><button class="btn btn-xs btn-success" type="button" class="btn btn-primary" data-toggle="modal" data-target="#video_modal">Xem video</button></td>
                <td><button type="button" data-video_id="'.$vid->video_id.'" class="btn btn-xs btn-danger btn-delete-video">Xóa video</button></td>
            </tr>
                ';
            }
        } else {
            $output.= '<tr>
                                            <td colspan="4">Chưa có video nào</td>
                                            </tr>
                ';
        }
        $output.= '<tbody>
        </table>
        </form>
';
        echo $output;
    }

    public function insert_video(Request $request) {
        $data = $request->all();
        $video = new Video();
        $sub_link = substr($data['video_link'],17);
        $video->video_title = $data['video_title'];
        $video->video_slug = $data['video_slug'];
        $video->video_link = $sub_link;
        $video->video_desc = $data['video_desc'];

        $get_image = $request->file('file');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/videos',$new_image);
            $video->video_image = $new_image;
           
        }
        $video->save();
    }

    public function update_video(Request $request){
        $data = $request->all();
        $video_id = $data['video_id'];
        $video_edit = $data['video_edit'];
        $video_check = $data['video_check'];
        $video = Video::find($video_id);
        if ($video_check=='video_title') {
            $video->video_title = $video_edit;
        }elseif ($video_check=='video_desc') {
            $video->video_desc = $video_edit;
        }elseif ($video_check=='video_link') {
            $sub_link = substr($video_edit,17);
            $video->video_link = $sub_link;
        }else {
            $video->video_slug = $video_edit;
        }
        $video->save();
    }

    public function delete_video(Request $request){
        $data = $request->all();
        $video_id = $data['video_id'];
        $video = Video::find($video_id);
        unlink('uploads/video/'.$video->video_image);
        $video->delete();
    }

    public function video_shop(Request $request) {
        $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $meta_desc = 'Video công ty';
        $meta_keywords = 'Điện thoại iphone chính hãng';
        $meta_title = "Video shop";
        $url_canonical = $request->url();

        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();

        // $all_product = DB::table("tbl_product")
        // ->join("tbl_category_product","tbl_category_product.category_id","=","tbl_product.category_id")
        // ->join("tbl_brand","tbl_brand.brand_id","=","tbl_product.brand_id")
        // ->orderby('product_id','desc')->get();

        $all_video = DB::table("tbl_videos")->paginate(6);
        // return view("pages.home")->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product);

        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        
        $max_price_range = $max_price ;

        return view("pages.video.video")->with(compact('cate_product','brand_product','all_video','meta_desc','meta_keywords','url_canonical','meta_title','slider','category_post'
    ,'min_price','max_price','max_price_range'));
    }

    public function update_video_image(Request $request){
        $get_image = $request->file('file');
        $video_id = $request->video_id;

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/videos',$new_image);

            $video = Video::find($video_id);
            unlink('uploads/video/'.$video->video_image);
            $video->video_image = $new_image;
            $video->save();
           }
    }

    public function watch_video(Request $request){
        $video_id = $request->video_id;
        $video = Video::find($video_id);
        $output['video_title'] = $video->video_title;
        $output['video_desc'] = $video->video_desc;
        $output['video_link'] = '<video id="example" class="vlite-js" data-youtube-id="'.$video->video_link.'"></video>';
        echo json_encode($output);
    }

}
