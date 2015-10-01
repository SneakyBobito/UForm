<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * Class Hidden
 * @semanticType input:hidden
 */
class Hidden extends Input
{
    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct("hidden", $name, $attributes, $validators, $filters);
        $this->addSemanticType("input:hidden");
    }
}
