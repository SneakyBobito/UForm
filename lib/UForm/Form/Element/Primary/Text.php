<?php

namespace UForm\Form\Element\Primary;

/**
 * Class Text
 * @semanticType input:text
 */
class Text extends Input
{
    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("text", $name, $attributes, $validators, $filters);
    }
}
