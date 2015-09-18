<?php

namespace UForm\Form\Element;
use UForm\Form\Element;

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
     * Get an element located directly in this element. There is an exception for unnamed elements : we will search inside directElements of unnamed elements
     * @param $name
     * @param null $values
     * @return null|Element|Container
     */
    public function getDirectElement($name, $values = null){
        foreach($this->getElements($values) as $elm){
            if ($name == $elm->getName()) {
                return $elm;
            } else if ( !$elm->getName() && $elm instanceof Container ) {
                /* @var $elm \UForm\Form\Element\Container */
                $element = $elm->getDirectElement($name);
                if($element) {
                    return $element;
                }
            }
        }
        return null;
    }

    /**
     * check if this element contains an element that is an instance of the given type
     * @param string $className the name of the class to search for
     * @return bool
     */
    public function hasDirectElementInstance($className){
        foreach($this->getElements() as $el){
            if(is_a($el, $className)){
                return true;
            }
        }
        return false;
    }

    /**
     * check if this element contains an element with the given semantic type
     * @param string $type the type to search for
     * @return bool
     */
    public function hasDirectElementSemanticType($type){
        foreach($this->getElements() as $el){
            if($el->hasSemanticType($type)){
                return true;
            }
        }
        return false;
    }

    public function setParent(Container $parent)
    {
        $r = parent::setParent($parent);
        foreach($this->getElements() as $element){
            $element->refreshParent();
        }
        return $r;
    }

    public function sanitizeData($data)
    {
        $data = parent::sanitizeData($data);
        foreach($this->getElements($data) as $element){
            $name = $element->getName();
            if($name){
                if(isset($data[$name])){
                    $newData = $data[$name];
                }else{
                    $newData = null;
                }
                $data[$name] = $element->sanitizeData($newData);
            }else{
                $data = $element->sanitizeData($data);
            }
        }
        return $data;
    }


}