<?php

namespace UForm\Forms\Element;

class Password extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("password", $name, $attributes, $validators, $filters);
    }
}