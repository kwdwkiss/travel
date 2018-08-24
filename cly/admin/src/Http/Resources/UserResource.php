<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/23
 * Time: 下午1:31
 */

namespace Cly\Admin\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        return $data;
    }
}