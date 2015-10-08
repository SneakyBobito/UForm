<?php
/**
 * @license see LICENSE
 */

namespace UForm\Filtering;

use UForm\Form\Element;
use UForm\Form\Element\Container;

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

    public function addFiltersFor(Element $element, array $filters)
    {
        $name = $element->getName(true, true);

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
