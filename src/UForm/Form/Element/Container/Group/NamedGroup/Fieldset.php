<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group\NamedGroup;

use UForm\Form\Element\Container\Group\NamedGroup;

/**
 * @semanticType fieldset
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 */
class Fieldset extends NamedGroup
{

    public function __construct($title = null, $name = null, $elements = null)
    {
        parent::__construct($title, $name, $elements);
        $this->addSemanticType("fieldset");
    }
}
