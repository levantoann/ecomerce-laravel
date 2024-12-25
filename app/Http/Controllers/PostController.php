<?php

namespace App\Http\Controllers;

use App\Models\CategoryPostModel;
use App\Models\Post;
use App\Models\Product;
use App\Models\Silder;
use Auth;
use DB;
use Excel;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class PostController extends Controller
{
    public function AuthLogin() {
        $admin_id = Auth::id();
        if ($admin_id) {
            return Redirect::to("dashboard");
        } else { 
              return Redirect::to("admin")->send();
        }
        }
    public function add_post() {
        $this->AuthLogin();
        $cate_post = CategoryPostModel::orderBy('cate_post_id','ASC')->get();

        return view('admin.post.add_post')->with(compact('cate_post'));
       }

       public function save_post(Request $request) { 
        $this->AuthLogin();
          $data = $request->all();
          $post = new Post();
          $post->post_title = $data['post_title'];
          $post->post_slug = $data['post_slug'];
          $post->post_desc = $data['post_desc'];
          $post->post_content = $data['post_content'];
          $post->post_meta_desc = $data['post_meta_desc'];
          $post->post_meta_keyword = $data['post_meta_keyword'];
          $post->post_status = $data['post_status'];
          $post->cate_post_id = $data['cate_post_id'];

          $get_image = $request->file('post_image');

          if($get_image) { 
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/post',$new_image);
            $post->post_image = $new_image;
            $post->save();
            Session::put('message','Thêm bài viết thành công');
            return redirect()->back();
          }
          else {
            Session::put('message','Thêm bài viết thất bại');
              return redirect()->back();
          }
    
       }

    public function all_post() {
        $this->AuthLogin();
        $all_post = Post::with('cate_post')->orderBy('post_id')->paginate(5);
        return view('admin.post.list_post')->with(compact('all_post'));
    }

    public function edit_post($post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);
        $cate_post = CategoryPostModel::orderBy('cate_post_id')->get();

        return view('admin.post.edit_post')->with(compact('post','cate_post'));
     }

     public function update_category_post(Request $request, $cate_id){

        $data = $request->all();

        $this->AuthLogin();
        $category_post = CategoryPostModel::find($cate_id);
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_slug = $data['cate_post_slug'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        $category_post->save();

        Session::put('message','Cập nhật danh mục bài viết thành công');
        return redirect('/all-category-post');
     }

     public function delete_post($post_id){
        $this->AuthLogin();
        $post = Post::find($post_id);
        $post_image = $post->post_image;
        if ($post_image) {
            $path ='uploads/post/'.$post_image;
            unlink($path);
        }
        $post->delete();

        Session::put('message','Xóa bài viết thành công');
        return redirect()->back();
     }

    public function danh_muc_bai_viet(Request $request,$post_slug) {
        $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();

        $catepost = CategoryPostModel::where('cate_post_slug',$post_slug)->take(1)->get();

        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        
        $max_price_range = $max_price ;
        
        foreach ($catepost as $key => $cate) {
            $meta_desc = $cate->cate_post_desc;
            $meta_keywords = $cate->cate_post_slug;
            $meta_title = $cate->cate_post_name;
            $cate_id = $cate->cate_post_id;
            $url_canonical = $request->url();
        }

        $post = Post::with('cate_post')->where('post_status',1)->where('cate_post_id',$cate_id)->paginate(5);

        return view("pages.baiviet.danhmucbaiviet")->with('cate_product',$cate_product)->with('brand_product',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
        ->with('url_canonical',$url_canonical)->with('post',$post)->with('category_post',$category_post)
        ->with('slider',$slider)
        ->with('min_price', $min_price)
        ->with('max_price', $max_price)
        ->with('max_price_range', $max_price_range);
    }

    public function bai_viet(Request $request,$post_slug) {
        $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();

        $post = Post::with('cate_post')->where('post_status',1)->where('post_slug',$post_slug)->take(1)->get();

        foreach ($post as $key => $p) {
            $meta_desc = $p->post_meta_desc;
            $meta_keywords = $p->post_meta_keyword;
            $meta_title = $p->post_title;
            $cate_id = $p->cate_post_id;
            $url_canonical = $request->url();
            $cate_post_id = $p->cate_post_id;
        }

        $related = Post::with('cate_post')->where('post_status',1)->where('cate_post_id',$cate_post_id)
        ->whereNotIn('post_slug',[$post_slug])->take(5)->get();

        return view("pages.baiviet.baiviet")->with(compact('cate_product',
        'brand_product','meta_desc','meta_keywords',
        'url_canonical','meta_title','slider','category_post','post','related'));
    }

    public function update_post(Request $request,$post_id) {
        $this->AuthLogin();
        $data = $request->all();
        $post = Post::find($post_id);
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->post_meta_keyword = $data['post_meta_keyword'];
        $post->post_status = $data['post_status'];
        $post->cate_post_id = $data['cate_post_id'];

        $get_image = $request->file('post_image');

        if($get_image) { 
        $post_image_old = $post->post_image;
        $path ='uploads/post/'.$post_image_old;
        unlink($path);
          $get_name_image = $get_image->getClientOriginalName();
          $name_image = current(explode('.',$get_name_image));
          $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
          $get_image->move('uploads/post',$new_image);
          $post->post_image = $new_image;
         
        }
        $post->save();
        Session::put('message','Cập nhật bài viết thành công');
        return redirect()->back();
    }
    

}
