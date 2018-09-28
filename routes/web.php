<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/tietong-man');
});


//前台管理员登录页面
Route::get('/tietong-login', 'Tietong\TietongLoginController@login');

//前台管理员登录工作
Route::post('/tietong-login', 'Tietong\TietongLoginController@store');

//前台注销
Route::get('/tietong-out', function () {

    \Illuminate\Support\Facades\Auth::guard('tietongmaster')->logout();

    return redirect('tietong-login');
});

//前台路由组
Route::group(['middleware' => 'tietong.login'], function () {

    //前台首页
    Route::resource('/tietong-man', 'Tietong\TietongManController');
    Route::resource('/tietong-master', 'Tietong\TietongMasterController');
    Route::resource('/tietong-area', 'Tietong\TietongAreaController');
    Route::get('/tietong-man-file', 'Tietong\TietongManFileController@file_view');
    Route::post('/tietong-man-file', 'Tietong\TietongManFileController@file');
    Route::get('/tietong-man-down', 'Tietong\TietongManFileController@down');
});