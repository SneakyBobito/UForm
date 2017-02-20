<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Filter;
use UForm\Form\Element;
use UForm\Validator;

trait FilterBuilder
{

    /**
     * @see FluentElement::last()
     * @return Element
     */
    public abstract function last();

    /**
     * @param callable|Filter $filter
     * @return $this
     * @throws \Exception
     */
    public function filter($filter)
    {
        $this->last()->addFilter($filter);
        return $this;
    }

    public function trim($chars = null)
    {
        $this->last()->addFilter(new Filter\Trim($chars));
        return $this;
    }
}
