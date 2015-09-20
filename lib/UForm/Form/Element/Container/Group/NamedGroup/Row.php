<?php

namespace UForm\Form\Element\Container\Group\NamedGroup;

use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\NamedGroup;

/**
 * Class Row
 * @semanticType row
 */
class Row extends NamedGroup
{

    public function __construct($title = null, $name = null, $elements = null)
    {
        parent::__construct($title, $name, $elements);
        $this->addSemanticType("row");
    }
}
