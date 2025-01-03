<?php

namespace App\Http\Controllers;

use App\Models\CategoryPostModel;
use App\Models\Silder;
use Auth;
use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class CategoryPost extends Controller
{
    public function AuthLogin() {
        $admin_id = Auth::id();
        if ($admin_id) {
            return Redirect::to("dashboard");
        } else { 
              return Redirect::to("admin")->send();
        }
        }
     public function add_category_post() {
        $this->AuthLogin();
      return view("admin.category_post.add_category");
     }

     public function all_category_post() {
      $this->AuthLogin();
      $category_post = CategoryPostModel::orderBy('cate_post_id','ASC')->get();
      
      return view('admin.category_post.list_category')->with(compact('category_post'));
     }
  

     public function save_category_post(Request $request) { 
        $this->AuthLogin();
        $data = $request->all();
        $category_post = new CategoryPostModel();
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_slug = $data['cate_post_slug'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        $category_post->save();

        Session::put('message','Thêm danh mục bài viết thành công');
        return redirect()->back();
     }
  
     public function danh_muc_bai_viet($cate_post_slug) {

     }

     public function edit_category_post($category_post_id){
        $this->AuthLogin();
        $category_post = CategoryPostModel::find($category_post_id);

        return view('admin.category_post.edit_category')->with(compact('category_post'));
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

     public function delete_category_post($cate_id){
        $this->AuthLogin();
        $category_post = CategoryPostModel::find($cate_id);
        $category_post->delete();
        Session::put('message','Xóa danh mục bài viết thành công');
        return redirect()->back();
     }
}
