<?php

namespace UForm\Forms\Element;

class File extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("file", $name, $attributes, $validators, $filters);
    }
}