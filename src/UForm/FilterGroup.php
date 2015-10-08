<?php

namespace UForm;

use UForm\Filter\DirectClosure;

trait FilterGroup
{

    /**
     * @var Filter[]
     */
    protected $filterGroup = [];

    /**
     * Resets the internal filters and set the given filters instead
     *
     * @param array|null $filters array of the new filters to set.
     * Can be null or an empty array to reset remove all filters
     * @return $this
     * @throws Exception
     */
    public function setFilters($filters)
    {
        $this->filterGroup = [];

        if (null !== $filters) {
            return $this->addFilters($filters);
        } else {
            return $this;
        }
    }

    /**
     * Adds a filter to current list of filters
     *
     * @param callable|Filter $filter the filter to add.
     * It can also be a callback function that will be transformed in a @see DirectFilter
     * @throws Exception
     * @return Filter the filter added to the stack
     */
    public function addFilter($filter)
    {
        if (is_callable($filter)) {
            $filter = new DirectClosure($filter);
        } elseif (!is_object($filter) || !$filter instanceof Filter) {
            throw new InvalidArgumentException('filter', 'intance of UForm\Filter or closure', $filter);
        }
        $this->filterGroup[] = $filter;
        return $filter;
    }

    /**
     * Adds some filters
     *
     * @param array $filters list of filters to add
     * @return $this
     * @throws Exception
     */
    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
        return $this;
    }

    /**
     * Returns the element's filters
     * @return Filter[] the filters of the element
     */
    public function getFilters()
    {
        return $this->filterGroup;
    }
}
