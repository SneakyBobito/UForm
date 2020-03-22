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

    protected $value;

    public function __construct($name)
    {
        parent::__construct('hidden', $name);
        $this->addSemanticType('input:hidden');
        $this->addSemanticType('input__hidden');
    }
}
