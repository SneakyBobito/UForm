<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filter;

use UForm\Filter;

/**
 * Simple filter allows to filter a simple value
 *
 * @see UForm\Filter for moe controle on the filtering
 */
abstract class AbstractSimpleFilter extends Filter
{

    public function processFiltering(&$data, $name)
    {
        $value = isset($data[$name]) ? $data[$name] : null;
        $data[$name] = $this->filter($value);
    }


    /**
     * Filters the given value
     * @param mixed $value the value to filter
     * @return mixed
     */
    abstract public function filter($value);
}
