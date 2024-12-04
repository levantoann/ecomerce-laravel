<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Brand;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandProduct extends Controller
{
   public function AuthLogin() {
      $admin_id = Session::get("admin_id");
      if ($admin_id) {
          return Redirect::to("dashboard");
      } else { 
            return Redirect::to("admin")->send();
      }
      }
    public function add_brand_product() {
         $this->AuthLogin();
        return view("admin.add_brand_product");
       }
    
       public function all_brand_product() {
         $this->AuthLogin();
      //   $all_brand_product = DB::table("tbl_brand")->get();
        $all_brand_product = Brand::orderBy('brand_id','desc')->get();
        $manager_brand_product = view("admin.all_brand_product")->with("all_brand_product", $all_brand_product);
        return view('admin.admin_layout')->with("admin.all_brand_product",$manager_brand_product);
       }
    
       public function save_brand_product(Request $request) { 
          $this->AuthLogin();
          $data = $request->all();
          $brand = new Brand();
          $brand->brand_name = $data['brand_product_name'];
          $brand->slug_brand_product = $data['slug_brand_product'];
          $brand->brand_desc = $data['brand_product_desc'];
          $brand->brand_status = $data['brand_product_status'];
          $brand->save();
         //  $data = array();
         //  $data["brand_name"] = $request->brand_product_name;
         //  $data["brand_desc"] = $request->brand_product_desc;
         //  $data["brand_status"] = $request->brand_product_status;
         //  $data["slug_brand_product"] = $request->slug_brand_product;
         //  DB::table("tbl_brand")->insert($data);
          Session::put('message','Thêm thương hiệu sản phẩm thành công');
          return redirect('add-brand-product');
       }
    
       public function unactive_brand_product($brand_product_id) { 
         $this->AuthLogin();
          DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
          Session::put('message','Không kích hoạt thương hiệu sản phẩm');
          return Redirect::to('all-brand-product');
       }
    
       public function active_brand_product($brand_product_id) { 
         $this->AuthLogin();
          DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
          Session::put('message','Kích hoạt thương hiệu sản phẩm');
          return Redirect::to('all-brand-product');
       }
    
       public function edit_brand_product($brand_product_id) { 
         $this->AuthLogin();
         //  $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
          $edit_brand_product = Brand::where('brand_id',$brand_product_id)->get();
          $manager_brand_product = view("admin.edit_brand_product")->with("edit_brand_product", $edit_brand_product);
          return view('admin.admin_layout')->with("admin.edit_brand_product",$manager_brand_product);
       }
    
       public function update_brand_product(Request $request,$brand_product_id) { 
         $this->AuthLogin();
         $data = $request->all();
         $brand = Brand::find($brand_product_id);
         $brand->brand_name = $data['brand_product_name'];
         $brand->slug_brand_product = $data['slug_brand_product'];
         $brand->brand_desc = $data['brand_product_desc'];
         // $brand->brand_status = $data['brand_product_status'];
         $brand->save();
         //  DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data); 
          Session::put('message','Cập nhật thương hiệu sản phẩm thành công');
          return Redirect::to('all-brand-product');
       }
    
       public function delete_brand_product($brand_product_id) {   
         $this->AuthLogin();
          DB::table('tbl_brand')->where('brand_id',$brand_product_id)->delete(); 
          Session::put('message','Xóa thương hiệu sản phẩm thành công');
          return Redirect::to('all-brand-product');
       }

       public function show_brand_home(Request $request,$slug_brand_product) { 
        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")
        ->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();
   
         $brand_by_id = DB::table("tbl_product")->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')
         ->where("tbl_brand.slug_brand_product",$slug_brand_product)->get();

         $brand_name = DB::table('tbl_brand')->where('tbl_brand.slug_brand_product',$slug_brand_product)->limit(1)->get();
       

          $meta_keywords = "cc";
          foreach ($brand_by_id as $key => $val) { 
            $meta_desc = $val->brand_desc;
            $meta_title = $val->brand_desc;
            $url_canonical = $request->url();
         }
         return view('pages.brand.show_brand')->with('cate_product',$cate_product)->with('brand_product',$brand_product)
         ->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name)->with('meta_desc',$meta_desc)
         ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
      }
}
