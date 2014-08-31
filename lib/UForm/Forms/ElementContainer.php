<?php

namespace UForm\Forms;

/**
 *
 * Element that mays contain other elements
 *
 * Class ElementContainer
 * @package UForm\Forms
 */
abstract class ElementContainer extends Element {

    abstract public function getElement($name);
    abstract public function getElements($values=null);
    
    public function setParent(ElementContainer $p, $iname = null) {
        parent::setParent($p, $iname);
        
        foreach ($this->getElements() as $el){
            $el->setParent($this);
        }
        
    }

}