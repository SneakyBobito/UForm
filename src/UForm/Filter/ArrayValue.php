<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;

class ArrayValue extends AbstractSimpleFilter
{

    protected $allowNull;

    /**
     * ArrayValue constructor.
     * @param bool $allowNull
     */
    public function __construct($allowNull = false)
    {
        $this->allowNull = $allowNull;
    }


    /**
     * @inheritdoc
     */
    public function filter($value)
    {
        if (!is_array($value)) {
            if (null === $value && !$this->allowNull) {
                return [];
            }

            return [$value];
        } else {
            return $value;
        }
    }
}
