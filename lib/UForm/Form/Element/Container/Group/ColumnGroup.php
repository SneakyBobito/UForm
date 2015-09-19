<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element;

/**
 * @semanticType column
 * @method Column[] getElements($values=null)
 */
class ColumnGroup extends NamedGroup
{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct("div", $name, $elements);
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
