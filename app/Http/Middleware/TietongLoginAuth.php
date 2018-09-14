<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class TietongLoginAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //获取前台管理员模型
        $user = Auth::guard('tietongmaster')->user();

        if (is_null($user)) {

            //前台管理员模型获取失败

            //前往登录页面
            return redirect('tietong-login');

        }

        return $next($request);
    }
}
