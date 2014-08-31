<?php

namespace UForm\Forms\Element;

use UForm\Forms\Element;
use UForm\Forms\Exception;
use UForm\Validation\ChainedValidation
;
use UForm\Forms\ElementContainer;

/**
 * Collection
 *
 * @author sghzal
 */
class Collection extends ElementContainer{
    
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

    
    public function _render( $attributes , $values , $data , $prename = null ) {
        $render = "";
        
        foreach($values[$this->getName()] as $k=>$v){
            $newPrename = $this->getName($prename);
            $element = $this->__getElemement($k);
            $render .= $element->render( $attributes , $values[$this->getName()] , $data, $newPrename);
        }
        
        return $render;
    }
    
    
    public function prepareValidation($localValues,  ChainedValidation $cV){
        
        parent::prepareValidation($localValues, $cV);
        
        if( isset($localValues[$this->getName()]) && is_array($localValues[$this->getName()]) ){
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
            $element->setParent($this, $index);
            $this->__internalElementClones[$index] = $element;
        }

        return $this->__internalElementClones[$index];
    }

    public function getElement($name){
        return $this->elementDefinition;
    }



    public function getElements($values = null){
        
        if(!$values)
            return array();
        
        $el = array();

      

        $realValues = $values[$this->getName()] ;


        foreach($realValues as $k=>$v){
            $el[] = $this->__getElemement($k);
        }
        return $el;
    }



}