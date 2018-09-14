<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class TietongLeftProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // 使用闭包来指定视图组件
        View::composer(['Tietong.left'], function ($view) {

            $route = Route::currentRouteName();

            $route = explode('.', $route);

            $user = Auth::guard('tietongmaster')->user();
//dump($user);
            $view->with(['route' => $route, 'user' => $user]);
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
