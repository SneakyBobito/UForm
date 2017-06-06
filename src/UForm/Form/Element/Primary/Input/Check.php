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

    protected $defaultChecked;

    public function __construct($name, $defaultChecked = false)
    {
        parent::__construct('checkbox', $name);
        $this->addSemanticType('input:checkbox');
        $this->defaultChecked = $defaultChecked;
    }

    protected function overridesParamsBeforeRender($params, $value)
    {
        if (isset($value[$this->getName()])) {
            if ($value[$this->getName()]) {
                $params['checked'] = 'checked';
            }
        } elseif ($this->defaultChecked) {
            $params['checked'] = 'checked';
        }

        $params['value'] = 1;
        return $params;
    }
}
