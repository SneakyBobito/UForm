<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;

use UForm\Filter;

/**
 * Automatically remove the value (useful for disabled input)
 */
class RemoveValue extends Filter
{
    public function processFiltering(&$data, $name)
    {
        unset($data[$name]);
    }
}
