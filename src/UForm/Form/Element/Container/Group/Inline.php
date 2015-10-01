<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group;

/**
 * Class Inline
 * @semanticType inline
 */
class Inline extends Group
{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct($name, $elements);
        $this->addSemanticType("inline");
    }
}
