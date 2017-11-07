<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * input number
 * @semanticType input:number
 * @semanticType input:textfield
 * @semanticType input:text
 * @renderOption placeholder a placeholder text to show when it's empty
 * @renderOption leftAddon an addon to add to the left of the field
 * @renderOption rightAddon an addon to add to the right of the field
 */
class Number extends Input
{
    public function __construct($name)
    {
        parent::__construct('number', $name);
        $this->addSemanticType('input:textfield');
        $this->addSemanticType('input:text');
        $this->addSemanticType('input:number');
    }
}
