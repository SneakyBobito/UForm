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
    protected $scale;

    public function __construct($width, $scale = 100)
    {
        parent::__construct();
        $this->addSemanticType('column');

        if ($width < 0) {
            throw new Exception('Column width cant be negative');
        }

        if ($scale <= 0) {
            throw new Exception('Column width cant be 0 or negative');
        }
        $this->width = $width;
        $this->scale = $scale;
    }

    /**
     * @return null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getScale()
    {
        return $this->scale;
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

    public function getWidthOnScale($scale)
    {
        if (!is_integer($scale)) {
            throw new InvalidArgumentException('scale', 'int', $scale);
        }
        return  $scale * $this->getWidth() / $this->getScale();
    }

    /**
     * the size of this element given other elements from the parent, based
     * on the given scale (100 will be equivalent to %)
     * @param int $scale
     * @return int
     */
    public function getAdaptiveWidth($scale)
    {
        if (!is_integer($scale)) {
            throw new InvalidArgumentException('scale', 'int', $scale);
        }

        if (!$this->getParent()) {
            return $scale;
        }

        $percent = $this->getParent()->getWidthInPercent($this->getWidthOnScale(100), 100);
        return $scale * ($percent / 100);
    }
}
