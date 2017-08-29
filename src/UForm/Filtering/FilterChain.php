<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filtering;

use UForm\Form\Element;
use UForm\Form\Element\Container;
use UForm\InvalidArgumentException;

final class FilterChain
{

    /**
     * @var FilterItem[]
     */
    protected $filters;

    public function __construct()
    {

        $this->filters = ['children' => []];
    }

    /**
     * Add a filter for the given path
     * @param Element|string $element path of the data to filter or instance of the element to filter
     * @param array $filters
     */
    public function addFiltersFor($path, array $filters)
    {

        if (is_string($path)) {
            $name = $path;
        } elseif ($path instanceof Element) {
            $name = $path->getName(true, true);
        } else {
            throw new InvalidArgumentException('path', 'stirng or instance of Element', $path);
        }


        $nameParts = explode('.', $name);

        $currentArray = &$this->filters;

        while ($currentNamePart = array_shift($nameParts)) {
            if (!isset($currentArray['children'][$currentNamePart])) {
                $currentArray['children'][$currentNamePart] = [
                    'children'   => []
                ];
            }
            $currentArray = &$currentArray['children'][$currentNamePart];
        }

        if (!isset($currentArray['filterItem'])) {
            $currentArray['filterItem'] = new FilterItem();
        }

        $filterItem = $currentArray['filterItem'];
        $filterItem->addFilters($filters);
    }

    public function sanitizeData($data, $isSubmitted)
    {
        $this->recursiveSanitize($data, null, $this->filters, $isSubmitted);
        return $data;
    }


    private function recursiveSanitize(&$data, $currentName, $filterWrapper, $isSubmitted)
    {

        if ($currentName) {
            $nextData = &$data[$currentName];
        } else {
            $nextData = &$data;
        }

        foreach ($filterWrapper['children'] as $name => $wrapper) {
            $this->recursiveSanitize($nextData, $name, $wrapper, $isSubmitted);
        }

        if (isset($filterWrapper['filterItem'])) {
            /* @var $filters \UForm\Filter[] */
            $filters = $filterWrapper['filterItem']->getFilters();
            foreach ($filters as $filter) {
                $filter->processFiltering($data, $currentName, $isSubmitted);
            }
        }
    }
}
