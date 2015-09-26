<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * input text
 * @semanticType input:text
 */
class Text extends Input
{
    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("text", $name, $attributes, $validators, $filters);
    }
}
