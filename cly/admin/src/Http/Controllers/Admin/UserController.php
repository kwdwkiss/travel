<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/22
 * Time: 下午4:21
 */

namespace Cly\Admin\Http\Controllers\Admin;


use Cly\Admin\Exceptions\JsonException;
use Cly\Admin\Http\Resources\UserResource;
use Cly\Admin\Model\User;
use Cly\RegExp\RegExp;

class UserController
{
    public function index()
    {
        $mobile = request('mobile');

        $query = User::query();
        if ($mobile) {
            $query->where('mobile', $mobile);
        }

        return UserResource::collection($query->paginate());
    }

    public function create()
    {
        $mobile = request('mobile');
        $password = request('password');

        if (!preg_match(RegExp::MOBILE, $mobile)) {
            throw new JsonException('手机号码格式错误');
        }
        if (!preg_match(RegExp::PASSWORD, $password)) {
            throw new JsonException('密码必须包含字母、数字、符号两种组合且长度为8-16');
        }

        $user = User::query()
            ->where('mobile', $mobile)
            ->first();
        if ($user) {
            throw new JsonException('手机号已存在');
        }

        User::create([
            'mobile' => $mobile,
            'password' => bcrypt($password)
        ]);

        return [];
    }

    public function detail()
    {
        $id = request('id');

        $user = User::findOrFail($id);

        return new UserResource($user);
    }

    public function update()
    {
        $id = request('id');
        $password = request('password');

        if (!preg_match(RegExp::PASSWORD, $password)) {
            throw new JsonException('密码必须包含字母、数字、符号两种组合且长度为8-16');
        }

        $user = User::findOrFail($id);

        if ($password) {
            $user->update(['password' => bcrypt($password)]);
        }

        return [];
    }

    public function delete()
    {
        $id = request('id');

        $user = User::findOrFail($id);

        $user->delete();

        return [];
    }
}