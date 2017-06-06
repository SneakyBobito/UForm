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

    /**
     * @return bool
     */
    public function isDefaultChecked()
    {
        return $this->defaultChecked;
    }



    protected function overridesParamsBeforeRender($params, $value, \UForm\Form\FormContext $context = null)
    {

        $checked = isset($value[$this->getName()])
            && $value[$this->getName()];

        if ($checked) {
            $params['checked'] = 'checked';
        }

        $params['value'] = 1;
        return $params;
    }

    public function processFiltering(&$data, $name, $isSubmitted)
    {
        if ($isSubmitted) {
            $data[$name] = isset($data[$name]) && $data[$name];
        } else {
            $data[$name] = isset($data[$name]) ? $data[$name] : $this->isDefaultChecked();
        }
    }
}
