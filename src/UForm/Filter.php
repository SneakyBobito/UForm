<?php
/**
 * Filter
 */
namespace UForm;

/**
 * Filter class allows to clearly filter a dataset.
 *
 * @see UForm\Filter\AbstractSimpleFilter for simple value filtering
 *
 */
abstract class Filter
{

    /**
     * Filter the given data
     * @param array $data the array of data to filter
     * @param string $name index of the array item that is currently filtered
     * @return void
     */
    abstract public function processFiltering(&$data, $name);
}
