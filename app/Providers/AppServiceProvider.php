<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Video;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        view()->composer('*',function($view) {
            $min_price = Product::min('product_price');
            $max_price = Product::max('product_price');
            
            $max_price_range = $max_price ;
            
            
            $app_product = Product::all()->count();
            $app_post = Post::all()->count();
            $app_order = Order::all()->count();
            $app_video = Video::all()->count();
            $app_customer = Customer::all()->count();

            $view->with('min_price',$min_price)
            ->with('max_price',$max_price)
            ->with('max_price_range',$max_price_range)
            ->with('app_product',$app_product)
            ->with('app_post',$app_post)
            ->with('app_order',$app_order)
            ->with('app_video',$app_video)
            ->with('app_customer',$app_customer);
        });

       
    }
}
