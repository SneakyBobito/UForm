<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * Class Submit
 * @semanticType input:submit
 */
class Submit extends Input
{

    protected $submitValue;

    public function __construct($name = null, $value = null)
    {
        parent::__construct('submit', $name);

        $this->submitValue = $value;
        $this->addSemanticType('input:submit');
        $this->addSemanticType('input__submit');
    }

    /**
     * @return null
     */
    public function getSubmitValue()
    {
        return $this->submitValue;
    }

    public function overridesParamsBeforeRender($params, $value, \UForm\Form\FormContext $context = null)
    {
        $params = parent::overridesParamsBeforeRender($params, $value, $context);
        if ($this->submitValue) {
            $params['value'] = $this->submitValue;
        }
        return $params;
    }
}
