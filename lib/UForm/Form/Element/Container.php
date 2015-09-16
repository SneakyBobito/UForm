<?php

namespace UForm\Form\Element;

/**
 *
 * Element that mays contain other elements.
 * It only aims to be a common parent for Group and Collection
 *
 * Class ElementContainer
 * @package UForm\Form
 * @semanticType container
 */
abstract class Container extends Element {

    public function __construct($name = null, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->addSemanticType("container");
    }

    /**
     * @param $name
     * @return Element
     */
    abstract public function getElement($name);

    /**
     * @param null|array $values used for the "collection" element that is rendered according to a value set
     * @return Element[]
     */
    abstract public function getElements($values=null);

    /**
     * check if this element contains an element that is an instance of the given type
     * @param string $className the name of the class to search for
     * @return bool
     */
    public function hasDirectElementType($className){
        foreach($this->getElements() as $el){
            if(is_a($el, $className)){
                return true;
            }
        }
        return false;
    }

}