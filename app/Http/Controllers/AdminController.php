<?php

namespace App\Http\Controllers;

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
        $admin_id = Session::get("admin_id");
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
    
    public function show_dashboard() { 
        $this->AuthLogin();
        return view("admin.dashboard");
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
}