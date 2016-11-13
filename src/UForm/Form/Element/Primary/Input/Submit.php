<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form\Element\Primary\Input;

/**
 * Class Submit
 * @semanticType input:submit
 */
class Submit extends Input
{
    public function __construct($name = null)
    {
        parent::__construct('submit', $name);
        $this->addSemanticType('input:submit');
    }
}
