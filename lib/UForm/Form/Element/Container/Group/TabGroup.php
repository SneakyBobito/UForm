<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;


/**
 * Class TabGroup
 * @semanticType tabGroup
 */
class TabGroup extends Group{

    public function __construct($name = null, $elements = null)
    {
        parent::__construct($name, $elements);
        $this->addSemanticType("tabGroup");
    }


    public function addElement(Element $element)
    {
        if(!($element instanceof Tab)){
            throw new \Exception("Cant add non-tab element into tab group");
        }
        parent::addElement($element);
    }

}