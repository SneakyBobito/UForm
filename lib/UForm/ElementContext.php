<?php

/**
 * @copyright (c) Rock A Gogo VPC
 */


namespace UForm;


use UForm\Forms\ElementInterface;

class ElementContext {

    /**
     * @var ElementInterface
     */
    protected $element;
    protected $prename;

    function __construct($element, $prename)
    {
        $this->element = $element;
        $this->prename = $prename;
    }

    /**
     * @return \UForm\Forms\ElementInterface
     */
    public function getElement()
    {
        return $this->element;
    }



    /**
     * @return mixed
     */
    public function getPrename()
    {
        return $this->prename;
    }




}