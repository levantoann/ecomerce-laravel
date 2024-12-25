<?php

namespace App\Http\Controllers;

use App\Models\CategoryPostModel;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Silder;
use DB;
use Auth;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class ContactController extends Controller
{
    public function AuthLogin() {
        if(Session::get('login_normal')) {
         $admin_id = Auth::id();
         if ($admin_id) {
             return Redirect::to("dashboard");
     } else { 
         return Redirect::to("admin")->send();
     }
        }
     }
     
    public function lien_he(Request $request) {
        $category_post = CategoryPostModel::orderBy('cate_post_id','DESC')->get();
        $slider = Silder::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();
        $meta_desc = 'Liên hệ';
        $meta_keywords = 'Liên hệ';
        $meta_title = "Liên hệ với chúng tôi";
        $url_canonical = $request->url();

        $cate_product = DB::table("tbl_category_product")->where('category_status','1')->orderBy("category_id","desc")->get();
        $brand_product = DB::table("tbl_brand")->where('brand_status','1')->orderBy("brand_id","desc")->get();

        $contact = Contact::where('info_id',1)->get();

        $all_product = DB::table("tbl_product")->where("product_status","1")->orderBy('product_id','desc')->limit(4)->get();
        // return view("pages.home")->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product);
        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        
        $max_price_range = $max_price ;

        return view('pages.lienhe.contact')->with(compact('cate_product','brand_product',
        'all_product','meta_desc','meta_keywords','url_canonical','meta_title','slider','category_post','contact'
      ,'min_price','max_price','max_price_range'));
    }

    public function information() {
        $contact = Contact::where('info_id',1)->get();
        return view('admin.information.add_information')->with(compact('contact'));
    }
    public function update_info(Request $request, $info_id) {
        $data = $request->all();
        $contact = Contact::find($info_id);

        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fange = $data['info_fange'];
        $get_image = $request->file('info_image');

          $path = 'uploads/info/';
          if($get_image) { 
            unlink($path.$contact->info_image);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $contact->info_image = $new_image;
           
          }
        $contact->save();
        return redirect()->back()->with('message','Cập nhật thông tin website thành công');
    }

    public function save_information(Request $request){
        $data = $request->all();
        $contact = new Contact();
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fange = $data['info_fange'];

        $get_image = $request->file('info_image');

          $path = 'uploads/info/';
          if($get_image) { 
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move($path,$new_image);
            $contact->info_image = $new_image;
           
          }
        $contact->save();
        return redirect()->back()->with('message','Cập nhật thông tin website thành công');
    }

   
}
