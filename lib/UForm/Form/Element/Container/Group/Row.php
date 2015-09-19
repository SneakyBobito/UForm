<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element\Group;

/**
 * Class Row
 * @semanticType row
 */
class Row extends NamedGroup
{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct("div", $name, $elements);
        $this->addSemanticType("row");
    }
}
