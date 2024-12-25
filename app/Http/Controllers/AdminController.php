<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\Video;
use App\Models\Visitor;
use Auth;
use Carbon\Carbon;
use DB;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Social;
use App\Models\Login;
use Socialite;
session_start();

class AdminController extends Controller
{

    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->stateless()->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_login',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/admin/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }else{

            $hieu = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => '',

                ]);
            }
            $hieu->login()->associate($orang);
            $hieu->save();

            $account_name = Login::where('admin_id',$account->user)->first();

            Session::put('admin_name',$account_name->admin_name);
             Session::put('admin_id',$account_name->admin_id);
            return redirect('/admin/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } 
    }
    public function login_google(){
        return Socialite::driver('google')->redirect();
   }
public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
        // return $users->id;
        $authUser = $this->findOrCreateUser($users,'google');
        if($authUser) {
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
        }else {
            // Nếu không tìm thấy, có thể hiển thị thông báo lỗi hoặc tạo tài khoản mới
            return redirect('/admin')->withErrors(['error' => 'Admin không tồn tại trong hệ thống.']);
        }
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
      
       
    }
    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){

            return $authUser;
        } else {
            $customer_new = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider)
            ]);
    
            $orang = Login::where('admin_email',$users->email)->first();
    
                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $users->name,
                        'admin_email' => $users->email,
                        'admin_password' => '',
    
                        'admin_phone' => '',
                        'admin_status' => 1
                    ]);
                }
            $customer_new->login()->associate($orang);
            $customer_new->save();
            return $customer_new;
        }
      
       
        


    }





    
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
    public function index() {
        return view("admin.admin_login");
    }
    
    public function show_dashboard(Request $request) { 
        $this->AuthLogin();
        $users_ip_address = $request->ip();
        // Sửa lại việc tính ngày đầu tháng trước
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString(); // Sửa lại để lấy cuối tháng trước
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString(); // Sửa lại để lấy đầu tháng này
        $oneyears = Carbon::now('Asia/Ho_Chi_Minh')->subYear()->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        
        $visitor_of_lastmonth = Visitor::whereBetween('date_visitor',[$early_last_month,$end_of_last_month])->get();
        $visitor_of_last_month_count = $visitor_of_lastmonth->count();
        
        $visitor_of_thismonth = Visitor::whereBetween('date_visitor',[$early_this_month,$now])->get();
        $visitor_of_this_month_count = $visitor_of_thismonth->count();
        
        $visitor_of_year = Visitor::whereBetween('date_visitor',[$oneyears,$now])->get();
        $visitor_of_year_count = $visitor_of_year->count();

        $visitors = Visitor::all();
        $visitors_total = $visitors->count();

        $visitor_current = Visitor::where('ip_address', $users_ip_address)->get(); // Sử dụng where thay vì whereBetween
        $visitor_count = $visitor_current->count();

        if ($visitor_count<1) {
           $visitor = new Visitor();
           $visitor->ip_address = $users_ip_address;
           $visitor->date_visitor = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
           $visitor->save();
        }

       

        // $product = Product::all()->count();
        // $product_views = Product::orderBy('product_views','DESC')->take(20)->get();
        // $post = Post::all()->count();
        // $post_views = Post::orderBy('post_views','DESC')->take(20)->get();
        $order = Order::all()->count();
        $video = Video::all()->count();
        $customer = Customer::all()->count();
        return view("admin.dashboard")->with(
            compact('visitors_total','visitor_count','visitor_of_last_month_count','visitor_of_this_month_count','visitor_of_year_count'
            ,'order','video','customer'));
    }

    public function dashboard(Request $request) { 
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table("tbl_admin")->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if($result) {
            Session::put('admin_name', $result->admin_name);
            Session::put('admin_id', $result->admin_id);
            return redirect('/dashboard');
        } else {
            Session::put('message', 'Tài khoản hoặc mật khẩu không chính xác');
            return redirect('/admin');
        }
    }

    public function logout() {
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id',null);
        return redirect('admin');
        
    }

   public function filter_by_date(Request $request) {
    $data = $request->all();
    $from_date = $data['from_date'];
    $to_date = $data['to_date'];

    $get = Statistic::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();

    foreach($get as $key => $val) {
        $chart_data[] = array(
            'period' => $val->order_date,
            'order' => $val->total_order,
            'sales' => $val->sales,
            'profit' => $val->profit,
            'quantity' => $val->quantity,
        );
    }
    echo $data = json_encode($chart_data);
   }
   
   public function dashboard_filter(Request $request){
        $data = $request->all();

        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth()->toDateString();
   
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['dashboard_value']=='7ngay') {
            $get = Statistic::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();

        }elseif($data['dashboard_value']=='thangtruoc') {
            $get = Statistic::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','ASC')->get();
        }
        elseif($data['dashboard_value']=='thannay') {
            $get = Statistic::whereBetween('order_date',[$dauthangnay,$now])->orderBy('order_date','ASC')->get();
        }
        else {
            $get = Statistic::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }
        foreach($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function days_order(Request $request) {
        $sub39days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30    )->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $get = Statistic::whereBetween('order_date',[$sub39days,$now])->orderBy('order_date','ASC')->get();

        foreach($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }
}
