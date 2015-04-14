<?php

namespace UForm\Builder;

use UForm\Builder;
use UForm\Forms\Element\Bootstrap\BootstrapText;
use UForm\Forms\Group\Bootstrap\Panel;
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
     * @param $name
     * @param $hname
     * @return $this
     */
    public function text($name, $hname){
        $element = new BootstrapText($name);
        $this->_makeInput($element, $name, $hname);
        $this->_add($element);
        if(isset($this->classes["input-text"])){
            $element->addClass($this->classes["input-text"]);
        }

        return $this;
    }




    /**
     * add a left addon for input group (bootstrap inputs only)
     * @param $text
     * @return $this
     * @throws \Exception
     * @throws \UForm\Forms\Exception
     */
    public function leftAddon($text){
        $this->last()->setUserOption("leftAddon", $text);
        return $this;
    }

    /**
     * add a right addon for input group (bootstrap inputs only)
     * @param $text
     * @return $this
     * @throws \Exception
     * @throws \UForm\Forms\Exception
     */
    public function rightAddon($text){
        $this->last()->setUserOption("rightAddon", $text);
        return $this;
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


    public function panel($name){
        $element = new Panel($name);
        $this->_add($element);
        $this->_stack($element);

        return $this;
    }


}