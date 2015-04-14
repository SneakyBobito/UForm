<?php


namespace UForm\Forms\Group\Bootstrap;


use UForm\Forms\Group\NamedGroup;

class Panel extends NamedGroup {

    public function __construct($name = null)
    {
        parent::__construct("div", $name, null);
        $this->addClass("panel");
    }

}