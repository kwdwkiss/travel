<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/22
 * Time: 下午4:20
 */

namespace Cly\Admin\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cly\Admin\Exceptions\JsonException;
use Cly\Admin\Http\Resources\AdminResource;
use Cly\Admin\Model\Admin;
use Cly\RegExp\RegExp;

class AdminController extends Controller
{
    public function index()
    {
        $name = request('name');
        $query = Admin::query();
        if ($name) {
            $query->where('name', $name);
        }
        return AdminResource::collection($query->paginate());
    }

    public function create()
    {
        $name = request('name');
        $password = request('password');

        if (!preg_match(RegExp::PASSWORD, $password)) {
            throw new JsonException('密码必须包含字母、数字、符号两种组合且长度为8-16');
        }

        Admin::create([
            'name' => $name,
            'password' => bcrypt($password)
        ]);

        return [];
    }

    public function detail()
    {
        $id = request('id');

        $admin = Admin::findOrFail($id);

        return new AdminResource($admin);
    }

    public function update()
    {
        $id = request('id');
        $password = request('password');

        if (!preg_match(RegExp::PASSWORD, $password)) {
            throw new JsonException('密码必须包含字母、数字、符号两种组合且长度为8-16');
        }

        $admin = Admin::findOrFail($id);

        if ($password) {
            $admin->update(['password' => bcrypt($password)]);
        }

        return [];
    }

    public function delete()
    {
        $id = request('id');

        $admin = Admin::findOrFail($id);

        if ($admin->id == \Auth::guard('admin')->user()->id) {
            throw new JsonException('不能删除自己');
        }

        $admin->delete();

        return [];
    }
}