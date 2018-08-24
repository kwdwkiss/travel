<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/21
 * Time: 上午10:19
 */

namespace Cly\Admin\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cly\Admin\Http\Resources\AdminResource;

class IndexController extends Controller
{
    public function index()
    {
        $admin = \Auth::guard('admin')->user();
        $laravel = [
            'user' => $admin ? new AdminResource($admin) : null
        ];
        return view('cly_admin::admin', compact('laravel'));
    }

    public function login()
    {
        $username = request('username');
        $password = request('password');

        if (\Auth::guard('admin')->attempt([
            'name' => $username,
            'password' => $password
        ])) {
            return [];
        } else {
            return [
                'code' => 100,
                'message' => '登录失败'
            ];
        }
    }

    public function logout()
    {
        \Auth::guard('admin')->logout();
        return [];
    }

    public function user()
    {
        $admin = \Auth::guard('admin')->user();
        return $admin ? new AdminResource($admin) : [];
    }

    public function info()
    {
        return [];
    }
}