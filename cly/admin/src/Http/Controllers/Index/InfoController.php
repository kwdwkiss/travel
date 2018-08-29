<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/29
 * Time: 上午12:25
 */

namespace Cly\Admin\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Cly\Admin\Exceptions\JsonException;
use Cly\Admin\Http\Resources\InfoResource;
use Cly\Admin\Model\Info;

class InfoController extends Controller
{
    public function search()
    {
        $type = request('type');
        $name = request('name');

        app('taxonomy')->check('info_type', $type);
        if (!$name) {
            throw new JsonException('查询名称不能为空');
        }

        $query = Info::query();
        $query->where('type', $type);
        $query->where('name', 'like', "%$name%");

        return InfoResource::collection($query->paginate());
    }

    public function typeIn()
    {
        $type = request('type');
        $name = request('name');
        $address = request('address');
        $remark = request('remark');
        $phone = request('phone');

        app('taxonomy')->check('info_type', $type);

        $nameExists = Info::query()
            ->where('type', $type)
            ->where('name', $name)->first();
        if ($nameExists) {
            throw new JsonException('名称已存在，请用其他名称');
        }

        $user = \Auth::guard('user')->user();

        Info::create([
            'user_id' => $user->id,
            'type' => $type,
            'name' => $name,
            'address' => $address,
            'remark' => $remark,
            'phone' => $phone,
        ]);

        return [];
    }
}