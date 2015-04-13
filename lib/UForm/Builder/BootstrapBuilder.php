<?php

namespace UForm\Builder;

use UForm\Builder;
use UForm\Forms\Group\Column;

class BootstrapBuilder extends Builder{


    function __construct()
    {
        parent::__construct();
        $this->classes = [

            "row" => "row-fluid",
            "input-text" => "form-control"

        ];
    }

    /**
     * @param null $name
     * @param int $width
     * @return $this
     * @throws \Exception
     */
    public function column($width, $name = null)
    {

        $element = new Column($name);

        $this->_add($element);
        $this->_stack($element);

        $element->addClass("col-md-$width");
        $element->setUserOption("col-width", $width);

        return $this;

    }


}