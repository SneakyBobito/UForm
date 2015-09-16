<?php

namespace UForm\Form\Group;

use UForm\Form\Element\Group;
use UForm\Tag;

/**
 * @semanticType column
 */
class Column extends NamedGroup{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct("div", $name, $elements);
        $this->addSemanticType("column");
    }

}