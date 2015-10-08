<?php

namespace UForm\Form\Element\Container\Group\Structural;

use UForm\Form\Element\Container\Group\StructuralGroup;

/**
 * Class Tab
 * @semanticType tab
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 */
class Tab extends StructuralGroup
{

    public function __construct($title = null)
    {
        parent::__construct($title);
        $this->setOption("title", $title);
        $this->addSemanticType("tab");
    }
}
