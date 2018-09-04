<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/17
 * Time: 下午3:04
 */

Route::name('admin.')->prefix('admin')->middleware('web')->namespace('Cly\Admin\Http\Controllers\Admin')->group(function () {

    Route::get('/', 'IndexController@index');
    Route::post('/index/login', 'IndexController@login');
    Route::get('/index/logout', 'IndexController@logout');
    Route::get('/index/user', 'IndexController@user');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/index/info', 'IndexController@info');

        Route::get('/admin/index', 'AdminController@index');
        Route::post('/admin/create', 'AdminController@create');
        Route::get('/admin/detail', 'AdminController@detail');
        Route::post('/admin/update', 'AdminController@update');
        Route::post('/admin/delete', 'AdminController@delete');

        Route::get('/user/index', 'UserController@index');
        Route::post('/user/create', 'UserController@create');
        Route::get('/user/detail', 'UserController@detail');
        Route::post('/user/update', 'UserController@update');
        Route::post('/user/delete', 'UserController@delete');

        Route::get('/info/index', 'InfoController@index');
        Route::post('/info/create', 'InfoController@create');
        Route::get('/info/detail', 'InfoController@detail');
        Route::post('/info/update', 'InfoController@update');
        Route::post('/info/delete', 'InfoController@delete');

        #replace_routes#
    });
});