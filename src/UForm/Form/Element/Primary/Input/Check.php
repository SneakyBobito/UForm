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
class Check extends Input implements Filter
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

    public function processFiltering(&$data, $name)
    {
        if (isset($data[$name])) {
            if ($data[$name]) {
                $data[$name] = true;
            } else {
                $data[$name] = false;
            }
        } else {
            $data[$name] = false;
        }
    }
}
