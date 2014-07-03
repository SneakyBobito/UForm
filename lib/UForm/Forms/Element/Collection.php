<?php

namespace UForm\Forms\Element;

use UForm\Forms\Element;
use UForm\Validation\ChainedValidation
;
use UForm\Forms\ElementContainer;

/**
 * Collection
 *
 * @author sghzal
 */
class Collection extends Element{
    
    /**
     * @var \UForm\Forms\Element
     */
    protected $elementDefinition;
    protected $min;
    protected $max;





    public function __construct($name, $elementDefinition, $min = 1, $max = -1) {
        parent::__construct($name);
        $this->elementDefinition = $elementDefinition;
        $this->min = $min;
        $this->max = $max;
        $this->elementDefinition->setName(null);
    }
    
    public function setForm($form) {
        parent::setForm($form);
        $this->elementDefinition->setForm($form);
    }

    
    public function render( $attributes , $values , $data , $prename = null ) {
        $render = "";
        
        foreach($values[$this->getName()] as $k=>$v){
            $newPrename = $this->getName($prename);
            $element = $this->__getElemement($k);
            $render .= $element->render( $attributes , $v , $data, $newPrename);
        }
        
        return $render;
    }
    
    
    public function prepareValidation($localValues,  ChainedValidation $cV , $prename = null){
        
        parent::prepareValidation($localValues, $cV, $prename);
        
        if( isset($localValues[$this->getName()]) && is_array($localValues[$this->getName()]) ){
            foreach ($localValues[$this->getName()] as $k=>$v){
                $newPrename = $this->getName($prename,true);
                $element = $this->__getElemement($k);
                $element->prepareValidation($localValues[$this->getName()], $cV,$newPrename);
            }
        }

    }


    // CLONED INSTANCES CONTAINER
    private $__internalElementClones;

    private function __getElemement($index){
        if(!$this->__internalElementClones)
            $this->__internalElementClones = array();

        if(!isset($this->__internalElementClones[$index])){
            $element = clone $this->elementDefinition;
            $element->setName($index);
            $this->__internalElementClones[$index] = $element;
        }

        return $this->__internalElementClones[$index];
    }

    public function getElement($name){
        return $this->elementDefinition;
    }



    public function getElements($values){
        $el = array();
        foreach($values as $v){
            $el[] = $v;
        }
        return $el;
    }



}