<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\NamedGroup\Tab;
use UForm\InvalidArgumentException;

/**
 * Class TabGroup
 * @semanticType tabGroup
 */
class TabGroup extends Group
{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct($name, $elements);
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
