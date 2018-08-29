<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/26
 * Time: 下午12:03
 */

namespace Cly\Admin;


use Cly\Admin\Exceptions\TaxonomyException;
use Illuminate\Contracts\Support\Arrayable;

class Taxonomy implements Arrayable
{

    protected $data = [
        'info_type' => [
            ['id' => 1, 'label' => '景区'],
        ]
    ];

    public function check($taxonomy, $type)
    {
        if (!isset($this->data[$taxonomy])) {
            throw new TaxonomyException("$taxonomy not exits");
        }
        foreach ($this->data[$taxonomy] as $item) {
            if ($item['id'] == $type) {
                return;
            }
        }
        throw new TaxonomyException("$taxonomy:$type not exits");
    }

    public function getLabel($taxonomy, $type)
    {
        if (!isset($this->data[$taxonomy])) {
            throw new TaxonomyException("$taxonomy not exits");
        }
        foreach ($this->data[$taxonomy] as $item) {
            if ($item['id'] == $type) {
                return $item['label'];
            }
        }
        throw new TaxonomyException("$taxonomy:$type not exits");
    }

    public function toArray()
    {
        return $this->data;
    }
}