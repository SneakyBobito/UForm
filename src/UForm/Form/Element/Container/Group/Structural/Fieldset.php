<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group\Structural;

use UForm\Form\Element\Container\Group\StructuralGroup;

/**
 * @semanticType fieldset
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 */
class Fieldset extends StructuralGroup
{

    public function __construct($title = null)
    {
        parent::__construct();
        $this->setOption("title", $title);
        $this->addSemanticType("fieldset");
    }
}
