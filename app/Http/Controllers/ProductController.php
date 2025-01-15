<?php

namespace App\Http\Controllers;

use App\Exports\ExportProduct;
use App\Imports\ImportProduct;
use App\Models\CategoryPostModel;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Silder;
use Auth;
use DB;
use Excel;
use File;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function AuthLogin() {
        $admin_id = Auth::id();
        if ($admin_id) {
            return Redirect::to("dashboard");
        } else { 
              return Redirect::to("admin")->send();
        }
        }
    public function add_product() {
        $this->AuthLogin();
        $cate_product = DB::table("tbl_category_product")->orderBy("category_id","desc")->get();
        $brand_product = DB::table("tbl_brand")->orderBy("brand_id","desc")->get();
        return view("admin.product.add_product")->with("cate_product",$cate_product)->with("brand_product",$brand_product);
       }
    
       public function all_product() {
        $this->AuthLogin();
        $all_product = DB::table("tbl_product")
        ->join("tbl_category_product","tbl_category_product.category_id","=","tbl_product.category_id")
        ->join("tbl_brand","tbl_brand.brand_id","=","tbl_product.brand_id")
        ->orderby('product_id','desc')->get();
        $manager_product = view("admin..product.all_product")->with("all_product", $all_product);
        return view('admin.admin_layout')->with("admin.product.all_product",$manager_product);
       }
    
       public function save_product(Request $request) { 
        $this->AuthLogin();
          $data = array();
          $data["product_name"] = $request->product_name;
          $data["product_quantity"] = $request->product_quantity;
          $data["slug_product"] = $request->slug_product;
          $data["product_tags"] = $request->product_tags;
          $data["product_price"] = $request->product_price;
          $data["price_cost"] = $request->price_cost;
          $data["product_content"] = $request->product_content;
          $data["product_desc"] = $request->product_desc;
          $data["category_id"] = $request->product_cate;
          $data["brand_id"] = $request->product_brand;
          $data["product_status"] = $request->product_status;
          $data["product_image"] = $request->product_image;
          $data["product_file"] = $request->product_file;
         $data["product_views"] = $request->product_views ?? 0;
          $data["product_sold"] = $request->product_sold;
          $get_image = $request->file('product_image');
          $get_document = $request->file('document');

          $path = 'uploads/product/';
          $path_gallery = 'uploads/gallery/';
          $path_document = 'uploads/document/';

          if($get_image) { 
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            File::copy($path.$new_image,$path_gallery.$new_image);
            $data['product_image'] = $new_image;
           
          }
          if($get_document) { 
           
            $get_name_document = $get_document->getClientOriginalName();
            $name_document = current(explode('.',$get_name_document));
            $new_document = $name_document.rand(0,99).'.'.$get_document->getClientOriginalExtension();
            $get_document->move($path_document,$new_document);
            $data['product_file'] = $new_document;
           
          }
          $pro_id = DB::table("tbl_product")->insertGetId($data);
          $gallery = new Gallery();
          $gallery->gallery_image = $new_image;
          $gallery->gallery_name = $new_image;
          $gallery->product_id = $pro_id;
          $gallery->save();
          Session::put('message','Thêm sản phẩm thành công');
          return redirect('all-product');
    
       }
    
       public function unactive_product($product_id) { 
        $this->AuthLogin();
          DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
          Session::put('message','Không kích hoạt sản phẩm');
          return Redirect::to('all-product');
       }
    
       public function active_product($product_id) { 
        $this->AuthLogin();
          DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
          Session::put('message','Kích hoạt sản phẩm');
          return Redirect::to('all-product');
       }
    
       public function edit_product($product_id) { 
        $this->AuthLogin();
            $cate_product = DB::table("tbl_category_product")->orderBy("category_id","desc")->get();
            $brand_product = DB::table("tbl_brand")->orderBy("brand_id","desc")->get();
          $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();
          $manager_product = view("admin.product.edit_product")->with("edit_product", $edit_product)->with("cate_product", $cate_product)
          ->with("brand_product", $brand_product);
          return view('admin.admin_layout')->with("admin.product.edit_product",$manager_product);
       }
    
       public function update_product(Request $request,$product_id) { 
        $this->AuthLogin();
          $data = array();
          $data["product_price"] = $request->product_price;
          $data["price_cost"] = $request->price_cost;
          $data["slug_product"] = $request->slug_product;
          $data["product_quantity"] = $request->product_quantity;
          $data["product_content"] = $request->product_content;
          $data["product_tags"] = $request->product_tags;
          $data["product_desc"] = $request->product_desc;
          $data["category_id"] = $request->product_cate;
          $data["brand_id"] = $request->product_brand;
          $data["product_status"] = $request->product_status;

          $get_image = $request->file("product_image");
          if($get_image) { 
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table("tbl_product")->where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
            return redirect('all-product');
          } 

          $get_document = $request->file("document");
          $path_document = 'uploads/document/';
          if($get_document) { 
                    
            $get_name_document = $get_document->getClientOriginalName();
            $name_document = current(explode('.',$get_name_document));
            $new_document = $name_document.rand(0,99).'.'.$get_document->getClientOriginalExtension();
            $get_document->move($path_document,$new_document);
            $data['product_file'] = $new_document;
            $product = Product::find('product_id',$product_id);
          
            unlink($path_document.$product->product_file);
           
            }
          

          DB::table("tbl_product")->where('product_id',$product_id)->update($data);
          

          Session::put('message','Cập nhật sản phẩm thành công');
          return Redirect::to('all-product');
       }
    
       public function delete_product($product_id) {   
        $this->AuthLogin();
          DB::table('tbl_product')->where('product_id',$product_id)->delete(); 
          Session::put('message','Xóa sản phẩm thành công');
          return Redirect::to('all-product');
       }

       public function details_product(Request $request,$slug_product) {
        $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")
        ->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();

        $details_product = DB::table("tbl_product")
        ->join("tbl_category_product","tbl_category_product.category_id","=","tbl_product.category_id")
        ->join("tbl_brand","tbl_brand.brand_id","=","tbl_product.brand_id")
        ->where('tbl_product.slug_product',$slug_product)->get();

        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        
        $max_price_range = $max_price ;

        foreach($details_product as $key => $value) {

            $category_id = $value->category_id;
            $product_id = $value->product_id;
            $meta_desc = $value->product_desc;
            $meta_keywords = $value->slug_product;
            $meta_title = $value->product_name;
            $url_canonical = $request->url();
            $product_cate = $value->category_name;
            $cate_slug = $value->slug_category_product;
        }

        $product = Product::where('product_id',$product_id)->first();
        $product->product_views = $product->product_views + 1;
        $product->save();

        $gallery = Gallery::where('product_id',$product_id)->get();

        $related_product = DB::table("tbl_product")
        ->join("tbl_category_product","tbl_category_product.category_id","=","tbl_product.category_id")
        ->join("tbl_brand","tbl_brand.brand_id","=","tbl_product.brand_id")
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.slug_product',[$slug_product])->get();

        $rating = Rating::where('product_id',$product_id)->avg('rating');
        $rating = round($rating);
        return view('pages.sanpham.show_details')->with('cate_product',$cate_product)->with('brand_product',$brand_product)->with('product_details',$details_product)->with('related',$related_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('slider',$slider)->with('category_post',$category_post)
        ->with('gallery',$gallery)->with('product_cate',$product_cate)
        ->with('cate_slug',$cate_slug)->with('rating',$rating)
        ->with('min_price', $min_price)
        ->with('max_price', $max_price)
        ->with('max_price_range', $max_price_range)
        ->with('product ', $product  );
       }

       public function export_csv_product(){
        return Excel::download(new ExportProduct , 'product.xlsx');
    }
  
    public function import_csv_product(Request $request){
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportProduct, $path);
        return back();
    }
    
    public function tag(Request $request, $product_tag) {
      $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
      $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
      $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")
      ->get();
      $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();
      $tag = str_replace("-"," ",$product_tag);
      $pro_tag = Product::where('product_status',0)->where('product_name','LIKE','%'.$tag.'%')
      ->orWhere('product_tags','LIKE','%'.$tag.'%')->orWhere('slug_product','LIKE','%'.$tag.'%')->get();
    
     
          $meta_desc = 'Tags tìm kiếm: '.$product_tag;
          $meta_keywords = 'Tag tìm kiếm:'.$product_tag;
          $meta_title = 'Tags tìm kiếm: '.$product_tag;
          $url_canonical = $request->url();

      return view('pages.sanpham.tag')->with('cate_product',$cate_product)->with('brand_product',$brand_product)
      ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
      ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
      ->with('slider',$slider)->with('category_post',$category_post)->with('product_tag', $product_tag)
      ->with('pro_tag', $pro_tag);
     }

     public function quickview(Request $request) {
      $product_id = $request->product_id;
      $product = Product::find($product_id);

      $gallery = Gallery::where('product_id',$product_id)->get();
      $output['product_gallery'] = '';

      foreach($gallery as $key => $gal){
        $output['product_gallery'].= '<p><img width="50%" src="uploads/gallery/'.$gal->gallery_image.'" /></p>';
      }

      $output['product_name'] = $product->product_name;
      $output['product_id'] = $product->product_id;
      $output['product_desc'] = $product->product_desc;
      $output['product_content'] = $product->product_content;
      $output['product_price'] = number_format($product->product_price,0,',','.').'VND';
      $output['product_image'] = '<p><img width="100%" src="uploads/product/'.$product->product_image.'" /></p>';

      $output['product_quickview_value'] = '
											<input type="hidden" value="'.$product->product_id.'" class="cart_product_id_'.$product->product_id.'">
											<input type="hidden" value="'.$product->product_name.'" class="cart_product_name_'.$product->product_id.'">
											<input type="hidden" value="'.$product->product_image.'" class="cart_product_image_'.$product->product_id.'">
											<input type="hidden" value="'.$product->product_quantity.'" class="cart_product_quantity_'.$product->product_id.'">
											<input type="hidden" value="'.$product->product_price.'" class="cart_product_price_'.$product->product_id.'">
											<input type="hidden" value="1" class="cart_product_qty_'.$product->product_id.'">';
      echo json_encode($output);
     }

     public function load_comment(Request $request){
      
      $product_id = $request->product_id;
   
      $comment = Comment::where('comment_product_id',$product_id)->where('comment_status', 1)->get();
      $comment_rep = Comment::with('product')->where('comment_parent_comment','>','0')->orderBy('comment_id','DESC')->get();
      $output = '';
      foreach($comment as $key => $comm){
        $output.= '
									<div class="row style_comment">
											<div class="col-md-2">
												
											</div>
											<div class="col-md-10">
												<p style="color:green">@'.$comm->comment_name.'</p>
												<p>'.$comm->comment_date.'</p>
												<p>'.$comm->comment.'</p>
											</div>
									</div>
                   <p></p>
        ';

        foreach($comment_rep as $key => $rep_comm) {
          if ($rep_comm->comment_parent_comment==$comm->comment_id) {
            $output.= '
            	<div class="row style_comment" style="margin:5px 40px;background-color:aquamarine">
											<div class="col-md-2">
												
											</div>
											<div class="col-md-10">
												<p style="color:blue">@Admin</p>
												<p>'.$rep_comm->comment.'</p>
												<p></p>
											</div>
									</div> <p></p>';
          }
        }
      }
      echo $output;
     }

     public function send_comment(Request $request){
      $product_id = $request->product_id;
      $comment_name = $request->comment_name;
      $comment_content = $request->comment_content;
      $comment_status = 0;
      $comment_parent_comment = 0;
      $comment = new Comment();
      $comment->comment = $comment_content;
      $comment->comment_name = $comment_name;
      $comment->comment_status = $comment_status;
      $comment->comment_product_id = $product_id;
      $comment->save();
     }

     public function list_comment(){
      $this->AuthLogin();
      $all_comment = Comment::with('product')->orderBy('comment_id','DESC')->get();
      $comment_rep = Comment::with('product')->where('comment_parent_comment','>','0')->orderBy('comment_id','DESC')->get();
      return view('admin.comment.list_comment')->with(compact('all_comment','comment_rep'));
     }

     public function allow_comment(Request $request){
      $data = $request->all();
      $comment = Comment::find($data['comment_id']);
      $comment->comment_status = $data['comment_status'];
      $comment->save();
     }

     public function reply_comment(Request $request){
      $data = $request->all();
      $comment = new Comment();
      $comment->comment = $data['comment'];
      $comment->comment_product_id = $data['comment_product_id'];
      $comment->comment_parent_comment = $data['comment_id'];
      $comment->comment_status = 0;
      $comment->comment_name = 'Admin';
      $comment->save();
     }

     public function insert_rating(Request $request) {
      $data = $request->all();
      $rating = new Rating();
      $rating->product_id = $data['product_id'];
      $rating->rating = $data['index'];
      $rating->save();
      echo 'done';
     }
     
     public function ckeditor_image(Request $request){
      
     }

     public function file_browser() {
      $paths = glob(public_path('uploads/ckeditor/*'));
      $fileNames = array();
      foreach ($paths as $key => $path) {
        array_push($fileNames,basename($path));
      }
      $data = array(
        'fileNames' => $fileNames
      );
      return view('admin.images.file_browser')->with($data);
     }

     public function delete_document(Request $request){
      $product = Product::find($request->product_id);
      $path_document = 'uploads/document/';
      unlink($path_document.$product->product_file);
      $product->product_file = '';
      $product->save();
     }
}
