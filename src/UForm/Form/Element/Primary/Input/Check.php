<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Filter;
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

    public function isDefaultChecked()
    {
        return $this->defaultChecked;
    }

    protected function overridesParamsBeforeRender($params, $value, \UForm\Form\FormContext $context = null)
    {

        if ($context) {
            $checked = $context->getOriginalValueFor($this->getName(true, true));
            if ($checked) {
                $params['checked'] = 'checked';
            }
        } elseif (isset($value[$this->getName()])) {
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
