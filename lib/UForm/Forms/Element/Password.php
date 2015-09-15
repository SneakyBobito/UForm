<?php

namespace UForm\Forms\Element;

/**
 * Class Password
 * @semanticType input:password
 */
class Password extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("password", $name, $attributes, $validators, $filters);
    }
}