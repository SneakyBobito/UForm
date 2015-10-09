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
    public function __construct($name)
    {
        parent::__construct("checkbox", $name);
        $this->addSemanticType("input:checkbox");
    }

    protected function overridesParamsBeforeRender($params, $value)
    {
        if (isset($value[$this->getName()]) && $value[$this->getName()]) {
            $params["checked"] = "checked";
        }
        $params["value"] = 1;
        return $params;
    }

    public function sanitizeData()
    {

    }
}
