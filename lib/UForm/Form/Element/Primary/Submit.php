<?php

namespace UForm\Form\Element;

use UForm\Form\Element\Primary\Input;

/**
 * Class Submit
 * @semanticType input:submit
 */
class Submit extends Input
{
    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("submit", $name, $attributes, $validators, $filters);
    }
}
