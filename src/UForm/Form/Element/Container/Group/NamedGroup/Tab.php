<?php

namespace UForm\Form\Element\Container\Group\NamedGroup;

use UForm\Form\Element\Container\Group\NamedGroup;

/**
 * Class Tab
 * @semanticType tab
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 */
class Tab extends NamedGroup
{

    public function __construct($title = null, $name = null, $elements = null)
    {
        parent::__construct($title, $name, $elements);
        $this->addSemanticType("tab");
    }
}
