<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group\NamedGroup;

use UForm\Form\Element\Container\Group\NamedGroup;

/**
 * @semanticType panel
 */
class Panel extends NamedGroup {

    public function __construct($title = null, $name = null, $elements = null)
    {
        parent::__construct($title, $name, $elements);
        $this->addSemanticType("panel");
    }

}