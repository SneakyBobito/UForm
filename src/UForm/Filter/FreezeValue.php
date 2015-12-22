<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;

use UForm\Filter;

/**
 * The value will always remains the same (useful for read only input)
 */
class FreezeValue extends AbstractSimpleFilter
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }


    /**
     * @inheritdoc
     */
    public function filter($v)
    {
        return $this->value;
    }
}
