<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;

use UForm\Filter;

/**
 * Transform any value to a boolean. Thus null, 0, negative values, empty strings... will become false while
 * 1, non empty string, array, etc... will become true
 *
 * That's the filter used for checkbox's default value
 */
class BoolToInt extends AbstractSimpleFilter
{

    /**
     * @inheritdoc
     */
    public function filter($value)
    {
        return $value ? 1 : 0;
    }
}
