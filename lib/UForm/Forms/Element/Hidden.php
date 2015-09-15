<?php

namespace UForm\Forms\Element;

/**
 * Class Hidden
 * @semanticType input:hidden
 */
class Hidden extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("hidden", $name, $attributes, $validators, $filters);
    }
}