<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element;

/**
 * Value range interface allows elements to implement custom rules for InRange validator
 *
 */
interface ValueRangeInterface
{

    /**
     * Check if the given data  are valid for the range
     * @param $data
     * @return mixed
     */
    public function valueIsInRange($data);
}
