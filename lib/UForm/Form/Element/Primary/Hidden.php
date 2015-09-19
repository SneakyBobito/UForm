<?php

namespace UForm\Form\Element\Primary;

/**
 * Class Hidden
 * @semanticType input:hidden
 */
class Hidden extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("hidden", $name, $attributes, $validators, $filters);
    }
}