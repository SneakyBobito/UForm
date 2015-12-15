<?php
/**
 * @license see LICENSE
 */

namespace UForm\DataBind;

class ArrayBinder extends Binder
{

    protected $data;

    public function __construct(array &$data)
    {
        $this->data = &$data;
    }


    public function bindKey($key, $value)
    {
        $this->data[$key] = $value;
    }
}
