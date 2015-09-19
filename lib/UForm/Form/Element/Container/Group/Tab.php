<?php

namespace UForm\Form\Element\Container\Group;

/**
 * Class Tab
 * @semanticType tab
 */
class Tab extends NamedGroup{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct("div", $name, $elements);
        $this->addSemanticType("tab");
    }

}