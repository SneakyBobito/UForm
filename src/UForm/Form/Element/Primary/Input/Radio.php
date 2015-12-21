<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

class Radio extends Input
{

    protected $value;

    public function __construct($name, $value)
    {
        parent::__construct("radio", $name);
        $this->addSemanticType("input:radio");
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    protected function overridesParamsBeforeRender($params, $value)
    {
        if (isset($value[$this->getName()]) && $value[$this->getName()] === $this->value) {
            $params["checked"] = "checked";
        }
        $params["value"] = (string)$this->value;
        return $params;
    }
}
