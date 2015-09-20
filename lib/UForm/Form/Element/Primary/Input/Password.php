<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * Class Password
 * @semanticType input:password
 */
class Password extends Input
{
    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("password", $name, $attributes, $validators, $filters);
    }
}
