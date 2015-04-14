<?php

namespace UForm\Forms\Element\Bootstrap;

class BootstrapText extends BootstrapInput{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("text", $name, $attributes, $validators, $filters);
    }
}