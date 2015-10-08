<?php

namespace UForm\Form\Element\Container\Group\Structural;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\StructuralGroup;
use UForm\InvalidArgumentException;

/**
 * @method Column[] getElements($values=null)
 * @semanticType columnGroup
 */
class ColumnGroup extends StructuralGroup
{
    public function __construct()
    {
        parent::__construct();
        $this->addSemanticType("columnGroup");
    }


    /**
     * Adds a column to the group. Column can only receive column as child.
     * @param Element $element
     */
    public function addElement(Element $element)
    {
        if (!($element instanceof Column)) {
            throw new InvalidArgumentException(
                "element",
                "Instance of Column",
                $element,
                "Cant add non-column element into columnGroup"
            );
        }
        parent::addElement($element);
    }

    /**
     * Calculate in percent what the given width represents compared to the total width of the children.
     * This helps to the creation of column based layout classes, e.g bootstrap classes span1, span2, span3...
     * @param int|float $width the width to compare
     * @return float|int the percent of the given width
     */
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
