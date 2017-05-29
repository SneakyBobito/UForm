<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;

class ArrayValue extends AbstractSimpleFilter
{

    /**
     * @inheritdoc
     */
    public function filter($value)
    {
        if (!is_array($value)) {
            return [$value];
        } else {
            return $value;
        }
    }
}
