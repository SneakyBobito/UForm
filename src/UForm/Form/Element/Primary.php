<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element;

use UForm\Form\Element;

/**
 * A primary element is the opposite of a container. It cant contain other elements
 *
 * @semanticType primary
 */
abstract class Primary extends Element
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->addSemanticType('primary');
    }
}
