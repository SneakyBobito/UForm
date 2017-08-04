<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * input text
 * @semanticType input:textfield
 * @semanticType input:text
 * @renderOption placeholder a placeholder text to show when it's empty
 * @renderOption leftAddon an addon to add to the left of the field
 * @renderOption rightAddon an addon to add to the right of the field
 */
class Range extends Input
{
    public function __construct($name, $min = null, $max = null, $step = null)
    {
        parent::__construct('range', $name);
        $this->addSemanticType('input:range');

        if (null !== $min) {
            $this->setAttribute('min', $min);
        }

        if (null !== $max) {
            $this->setAttribute('max', $max);
        }

        if (null !== $step) {
            $this->setAttribute('step', $step);
        }
    }
}
