<?php

namespace UForm\Forms\Element;

/**
 * Class Submit
 * @semanticType input:submit
 */
class Submit extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("submit", $name, $attributes, $validators, $filters);
    }
}