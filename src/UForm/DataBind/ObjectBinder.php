<?php
/**
 * @license see LICENSE
 */

namespace UForm\DataBind;

class ObjectBinder extends Binder
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function bindKey($key, $value)
    {
        $this->data->$key = $value;
    }
}
