<?php

namespace UForm\Form\Group;

use UForm\Form\Element\Group;
use UForm\Tag;

/**
 * @semanticType column
 */
class ColumnGroup extends NamedGroup{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct("div", $name, $elements);
        $this->addSemanticType("columnGroup");
    }

}