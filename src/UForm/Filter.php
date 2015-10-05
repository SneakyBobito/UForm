<?php
/**
 * Filter
 */
namespace UForm;

/**
 * UForm\Filter
 *
 * Base class for user defined filters.
 *
 */
abstract class Filter
{

    /**
     * Filters the given value
     * @param mixed $value the value to filter
     * @return mixed
     */
    abstract public function filter($value);
}
