<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * Class File
 * @semanticType input:file
 */
class File extends Input
{
    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("file", $name, $attributes, $validators, $filters);
    }
}
