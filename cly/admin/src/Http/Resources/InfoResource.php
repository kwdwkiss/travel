<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/23
 * Time: 下午1:31
 */

namespace Cly\Admin\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;

class InfoResource extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);

        $data['type_label'] = app('taxonomy')->getLabel('info_type', $data['type']);

        return $data;
    }
}