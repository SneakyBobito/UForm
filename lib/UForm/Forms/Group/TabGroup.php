<?php

namespace UForm\Forms\Group;

use UForm\Forms\Element\Group;

class TabGroup extends Group{

    public function addElement(\UForm\Forms\Element $element)
    {
        if(!($element instanceof Tab)){
            throw new \Exception("Cant add non-tab element into tab group");
        }
        parent::addElement($element);
    }

}