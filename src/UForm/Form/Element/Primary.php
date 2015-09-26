<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element;

use UForm\Form\Element;

/**
 * A primary element is the opposite of a container.
 * It cant contain other elements and therefor it can be rendered directly
 * It does not have children relation and therefor a name is required for a primary element
 * Class FinalElement
 * @semanticType primary
 */
abstract class Primary extends Element
{
    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->addSemanticType("primary");
    }
}
