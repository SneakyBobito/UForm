<?php

namespace UForm\Forms\Group;

use UForm\Forms\Element\Group;

/**
 * Class TabGroup
 * @semanticType tabgroup
 */
class TabGroup extends Group{

    public function addElement(\UForm\Forms\Element $element)
    {
        if(!($element instanceof Tab)){
            throw new \Exception("Cant add non-tab element into tab group");
        }
        parent::addElement($element);
        $this->addSemanticType("tabGroup");
    }

}