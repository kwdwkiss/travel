<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/17
 * Time: 下午3:03
 */

Route::name('index.')->middleware('web')->namespace('Cly\Admin\Http\Controllers\Index')->group(function () {

    Route::get('/', 'IndexController@index');

    Route::prefix('index')->group(function () {

        Route::post('/index/login', 'IndexController@login');
        Route::get('/index/logout', 'IndexController@logout');
        Route::get('/index/user', 'IndexController@user');
        Route::post('/index/sms', 'IndexController@sms');

        Route::post('/user/register', 'UserController@register');
        Route::post('/user/forget_password', 'UserController@forgetPassword');

        Route::get('/info/search', 'InfoController@search');


        Route::middleware(['auth:user'])->group(function () {

            Route::post('/info/type_in', 'InfoController@typeIn');

        });
    });
});