<?php

namespace UForm\Form\Element\Container\Group\Structural;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\StructuralGroup;
use UForm\InvalidArgumentException;

/**
 * Class TabGroup
 * @semanticType tabGroup
 * @renderOption tab-position  position of the tab "top", "bottom", "left" or "right". Default to top
 * @renderOption tab-justified  in some render engine you can make tab to fill all the width while having the same size
 */
class TabGroup extends StructuralGroup
{

    public function __construct()
    {
        parent::__construct();
        $this->addSemanticType("tabGroup");
    }


    public function addElement(Element $element)
    {
        if (!($element instanceof Tab)) {
            throw new InvalidArgumentException(
                "element",
                "Instance of Tab",
                $element,
                "Cannot add non-tab element into TabGroup"
            );
        }
        parent::addElement($element);
    }
}
