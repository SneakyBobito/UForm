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
class BooleanValue extends AbstractSimpleFilter
{

    /**
     * @inheritdoc
     */
    public function filter($value)
    {
        $newValue = filter_var($value, FILTER_VALIDATE_BOOLEAN, ['flags' => FILTER_NULL_ON_FAILURE]);

        if (null === $newValue) {
            if (is_string($value)) {
                if ($value == "null" || empty($value)) {
                    $newValue = false;
                } else {
                    $newValue = true;
                }
            } elseif (is_int($value) || is_float($value)) {
                $newValue = $value > 0;
            } else {
                $newValue = false;
            }
        }


        return $newValue;
    }
}
