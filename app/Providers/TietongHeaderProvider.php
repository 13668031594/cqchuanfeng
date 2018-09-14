<?php

namespace App\Providers;

use App\Models\Store\StoreList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TietongHeaderProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*// 使用类来指定视图组件
        View::composer('Index.footer', 'App\Http\ViewComposers\FooterComposer');*/

        // 使用闭包来指定视图组件
        View::composer(['Tietong.header'], function ($view) {

            $user = Auth::guard('tietongmaster')->user();

            $out = '/tietong-out';

            $view->with(['user' => $user, 'out' => $out]);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
