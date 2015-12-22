<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;

use UForm\Filter;

/**
 * Used to set a default value in a field
 */
class DefaultValue extends AbstractSimpleFilter
{

    protected $defaultValue;

    public function __construct($defaultValue)
    {
        $this->defaultValue = $defaultValue;

    }


    /**
     * @inheritdoc
     */
    public function filter($v)
    {
        if (null === $v) {
            return $this->defaultValue;
        }
        return $v;
    }
}
