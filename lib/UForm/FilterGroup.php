<?php

namespace UForm;


use UForm\Filter\DirectClosure;

trait FilterGroup {

    /**
     * @var Filter[]
     */
    protected $_filterGroup = [];

    /**
     * Resets the internal filters and set the given filters instead
     *
     * @param array|null $filters array of the new filters to set. Can be null or an empty array to reset remove all filters
     * @return $this
     * @throws Exception
     */
    public function setFilters($filters)
    {
        $this->_filterGroup = [];

        if(null !== $filters) {
            return $this->addFilters($filters);
        }else{
            return $this;
        }
    }

    /**
     * Adds a filter to current list of filters
     *
     * @param callable|Filter $filter the filter to add. It can also be a callback function that will be transformed in a @see DirectFilter
     * @throws Exception
     * @return Filter the filter added to the stack
     */
    public function addFilter($filter)
    {
        if (is_callable($filter)) {
            $filter = new DirectClosure($filter);
        } else if (!is_object($filter) || !$filter instanceof Filter) {
            throw new Exception('The filter parameter must be an object extending UForm\Filter ');
        }
        $this->_filterGroup[] = $filter;
        return $filter;
    }

    /**
     * Adds some filters
     *
     * @param array $filters list of filters to add
     * @return $this
     * @throws Exception
     */
    public function addFilters($filters){
        if (!is_array($filters)) {
            throw new Exception('Invalid parameter type.');
        }
        foreach($filters as $filter){
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
        return $this->_filterGroup;
    }

    /**
     * Apply filters of the element to sanitize the given data
     * @param mixed $data the data to sanitize
     * @return mixed the sanitized data
     */
    public function sanitizeData($data)
    {
        $filters = $this->getFilters();
        foreach ($filters as $filter) {
            $data = $filter->filter($data);
        }
        return $data;
    }

}