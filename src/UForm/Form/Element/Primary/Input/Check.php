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


    public function __construct($name, $value = null, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("checkbox", $name, $attributes, $validators, $filters);
        $this->value = $value;
    }

    protected function overridesParamsBeforeRender($params, $attributes, $value, $data, $prename = null)
    {
        if (isset($value[$this->getName()]) && $value[$this->getName()] == $this->value) {
            $params["checked"] = "checked";
        }

        if ($this->value) {
            $params["value"] = $this->value;
        } else {
            unset($params["value"]);
        }

        return $params;
    }

    /**
     * Get the checkbox value
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
