<?php

namespace UForm\Form\Element\Container\Group\Structural;

use UForm\Exception;
use UForm\Form\Element\Container;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\StructuralGroup;
use UForm\InvalidArgumentException;

/**
 * @semanticType column
 * @method ColumnGroup getParent()
 */
class Column extends StructuralGroup
{

    protected $width;

    public function __construct($width)
    {
        parent::__construct();
        $this->addSemanticType('column');

        if ($width < 0) {
            throw new Exception('Column width cant be negative');
        }
        $this->width = $width;
    }

    /**
     * @return null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @inheritdoc
     */
    public function setParent(Container $parent)
    {
        if (!($parent instanceof ColumnGroup)) {
            throw new Exception('The column parent must be a column group');
        }
        return parent::setParent($parent);
    }

    public function getAdaptiveWidth($factor)
    {
        if (!is_integer($factor)) {
            throw new InvalidArgumentException('factor', 'int', $factor);
        }

        $width = $this->getWidth();
        if (!$this->getParent()) {
            return $factor;
        }
        $percent = $this->getParent()->getWidthInPercent($width);
        return $factor * ($percent / 100);
    }
}
