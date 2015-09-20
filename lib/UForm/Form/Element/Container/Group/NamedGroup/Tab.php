<?php

namespace UForm\Form\Element\Container\Group\NamedGroup;

use UForm\Form\Element\Container\Group\NamedGroup;

/**
 * Class Tab
 * @semanticType tab
 */
class Tab extends NamedGroup
{

    public function __construct($title = null, $name = null, $elements = null)
    {
        parent::__construct($title, $name, $elements);
        $this->addSemanticType("tab");
    }
}
