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

        $this->filters = ["children" => []];
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
            throw new InvalidArgumentException("path", "stirng or instance of Element", $path);
        }


        $nameParts = explode(".", $name);

        $currentArray = &$this->filters;

        while ($currentNamePart = array_shift($nameParts)) {
            if (!isset($currentArray["children"][$currentNamePart])) {
                $currentArray["children"][$currentNamePart] = [
                    "children"   => []
                ];
            }
            $currentArray = &$currentArray["children"][$currentNamePart];
        }

        if (!isset($currentArray["filterItem"])) {
            $currentArray["filterItem"] = new FilterItem();
        }

        $filterItem = $currentArray["filterItem"];
        $filterItem->addFilters($filters);
    }

    public function sanitizeData($data)
    {
        return $this->recursiveSanitize($data, $this->filters);
    }

    private function recursiveSanitize($data, $filterWrapper)
    {
        if (isset($filterWrapper["filterItem"])) {
            $filters = $filterWrapper["filterItem"]->getFilters();
            foreach ($filters as $filter) {
                $data = $filter->filter($data);
            }
        }

        foreach ($filterWrapper["children"] as $name => $wrapper) {
            $value = isset($data[$name]) ? $data[$name] : null;
            $data[$name] = $this->recursiveSanitize($value, $wrapper);
        }

        return $data;
    }
}
