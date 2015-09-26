<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group;

/**
 * Class NamedGroup
 * @semanticType namedGroup
 */
abstract class NamedGroup extends Group
{

    public function __construct($title = null, $name = null, $elements = [])
    {
        parent::__construct($name, $elements);
        $this->setOption("title", $title);
        $this->addSemanticType("namedGroup");
    }
}
