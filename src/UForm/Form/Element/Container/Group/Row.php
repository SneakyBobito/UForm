<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\NamedGroup;

/**
 * Class Row
 * @semanticType row
 */
class Row extends Group
{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct($name, $elements);
        $this->addSemanticType("row");
    }
}
