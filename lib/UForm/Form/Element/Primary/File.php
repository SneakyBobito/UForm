<?php

namespace UForm\Form\Element\Primary;

/**
 * Class File
 * @semanticType input:file
 */
class File extends Input{
    public function __construct($name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("file", $name, $attributes, $validators, $filters);
    }
}