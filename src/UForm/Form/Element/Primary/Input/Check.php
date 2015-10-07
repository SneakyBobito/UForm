<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * input checkbox
 * @semanticType input:checkbox
 */
class Check extends Input
{

    protected $value;


    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("checkbox", $name, $attributes, $validators, $filters);
        $this->addSemanticType("input:checkbox");
    }

    protected function overridesParamsBeforeRender($params, $attributes, $value, $prename = null)
    {

        if (isset($value[$this->getName()]) && $value[$this->getName()]) {
            $params["checked"] = "checked";
        }

        $params["value"] = 1;

        return $params;
    }
}
