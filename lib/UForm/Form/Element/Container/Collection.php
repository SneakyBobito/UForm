<?php

namespace UForm\Form\Element\Container;

use UForm\Form\Element;
use UForm\Form\Element\Container;
use UForm\Validation\ChainedValidation;

/**
 * Collection
 *
 * @author sghzal
 * @semanticType collection
 */
class Collection extends Container{
    
    /**
     * @var \UForm\Form\Element
     */
    protected $elementDefinition;
    protected $min;
    protected $max;





    public function __construct($name, Element $elementDefinition, $min = 1, $max = -1) {
        parent::__construct($name);
        $this->elementDefinition = $elementDefinition;
        $this->min = $min;
        $this->max = $max;
        $this->elementDefinition->setName(null);
        $this->addSemanticType("collection");
    }
    
    public function _render( $attributes , $values , $data ) {
        $render = "";
        
        foreach($values[$this->getName()] as $k=>$v){
            $element = $this->__getElemement($k);
            $render .= $element->render( $attributes , $values[$this->getName()] , $data);
        }
        
        return $render;
    }
    
    
    public function prepareValidation($localvalues, chainedvalidation $cV){
        
        parent::prepareValidation($localValues, $cV);
        
        if(isset($localValues[$this->getName()]) && is_array($localValues[$this->getName()])) {
            foreach ($localValues[$this->getName()] as $k=>$v){
                $element = $this->__getElemement($k);
                $element->prepareValidation($localValues[$this->getName()], $cV);
            }
        }

    }


    // CLONED INSTANCES CONTAINER
    private $__internalElementClones;

    private function __getElemement($index){
        if (!$this->__internalElementClones) {
            $this->__internalElementClones = array();
        }

        if(!isset($this->__internalElementClones[$index])){
            $element = clone $this->elementDefinition;
            $element->setName($index);
            $element->setParent($this);
            $element->setInternalName($index);
            $this->__internalElementClones[$index] = $element;
        }

        return $this->__internalElementClones[$index];
    }

    public function getElement($name){
        return $this->elementDefinition;
    }



    public function getElements($values = null){
        
        if(!$values) {
            return array();
        }
        
        $el = array();

        $realValues = $values[$this->getName()] ;

        foreach($realValues as $k=>$v){
            $el[] = $this->__getElemement($k);
        }
        return $el;
    }



}