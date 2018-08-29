<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/28
 * Time: 上午11:33
 */

namespace Cly\Admin\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Cly\Admin\Http\Resources\InfoResource;
use Cly\Admin\Model\Info;

class InfoController extends Controller
{
    public function index()
    {
        $type = request('type');
        $name = request('name');

        $query = Info::query();
        if ($type) {
            app('taxonomy')->check('info_type', $type);
            $query->where('type', $type);
        }
        if ($name) {
            $query->where('name', 'like', "%$name%");
        }

        return InfoResource::collection($query->paginate());
    }

    public function create()
    {
        $type = request('type');
        $name = request('name');
        $address = request('address');
        $remark = request('remark');
        $content = request('content');

        app('taxonomy')->check('info_type', $type);

        Info::create([
            'type' => $type,
            'name' => $name,
            'address' => $address,
            'remark' => $remark,
            'content' => $content,
        ]);

        return [];
    }

    public function detail()
    {
        $id = request('id');

        $info = Info::findOrFail($id);

        return new InfoResource($info);
    }

    public function update()
    {
        $id = request('id');
        $type = request('type');
        $name = request('name');
        $address = request('address');
        $remark = request('remark');
        $content = request('content');

        app('taxonomy')->check('info_type', $type);

        $info = Info::findOrFail($id);

        $info->update([
            'type' => $type,
            'name' => $name,
            'address' => $address,
            'remark' => $remark,
            'content' => $content,
        ]);

        return [];
    }

    public function delete()
    {
        $id = request('id');

        $info = Info::findOrFail($id);

        $info->delete();

        return [];
    }
}