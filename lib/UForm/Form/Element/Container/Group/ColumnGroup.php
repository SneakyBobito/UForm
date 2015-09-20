<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\NamedGroup\Column;

/**
 * @method Column[] getElements($values=null)
 * @semanticType columnGroup
 */
class ColumnGroup extends Group
{
    public function __construct($name = null, $elements = null)
    {
        parent::__construct($name, $elements);
        $this->addSemanticType("columnGroup");
    }


    public function addElement(Element $element)
    {
        if (!($element instanceof Column)) {
            throw new \Exception("Cant add non-column element into column group");
        }
        parent::addElement($element);
    }

    public function getWidthInPercent($width)
    {
        $widthTotal = 0;
        foreach ($this->getElements() as $column) {
            $widthTotal += $column->getWidth();
        }

        if ($widthTotal == 0) {
            return 100;
        } else {
            return ($width / $widthTotal) * 100;
        }
    }
}
