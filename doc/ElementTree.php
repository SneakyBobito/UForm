<?php

namespace UForm\Doc;


class ElementTree implements NodeContainer {

    /**
     * @var ElementTreeNode
     */
    protected $parentNode = null;

    function __construct($parentClass){
        $this->parentNode =  new ElementTreeNode($parentClass);
    }

    public function addElement($className)
    {

        $parents = class_parents($className);
        $parents = array_reverse($parents);

        if (count($parents) > 0) {
            $parents[] = $className;
            $this->parentNode->add($parents);
        } else {
            if ($className != $this->parentNode->getClassName()) {
                throw new \Exception(
                    "Invalid class $className. Not a subclass of " . $this->parentNode->getClassName()
                );
            }
        }
    }
    /**
     * @return ElementTreeNode
     */
    public function getNode(){
        return $this->parentNode;
    }

    public function getNodes(){
        return [$this->parentNode];
    }


}