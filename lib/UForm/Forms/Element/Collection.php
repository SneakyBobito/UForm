<?php

namespace UForm\Forms\Element;

use UForm\Forms\Element

;
use UForm\Forms\ElementContainer;

/**
 * Collection
 *
 * @author sghzal
 */
class Collection extends ElementContainer{
    
    /**
     * @var \UForm\Forms\ElementInterface
     */
    protected $elementDefinition;
    protected $min;
    protected $max;

    public function __construct($name, $elementDefinition, $min = 1, $max = -1) {
        parent::__construct($name);
        $this->elementDefinition = $elementDefinition;
        $this->min = $min;
        $this->max = $max;        
    }
    
    public function setForm($form) {
        parent::setForm($form);
        $this->elementDefinition->setForm($form);
    }

    
    public function render( $attributes , $values , $data , $prename = null ) {
        $render = "";
        
        foreach($values[$this->getName()] as $k=>$v){
            $newPrename = $this->getName($prename) . "[$k]"; 
            $render .= $this->elementDefinition->render( $attributes , $v , $data, $newPrename);
        }
        
        return $render;
    }
    
    public function validate($values, $data, $prename = null , \UForm\Validation\ChainedValidation $cV = null) {
        
        $validation = parent::validate($values, $data, $prename, $cV);
        
        // TODO add validator min/max
        
        if( isset($values[$this->getName()]) && is_array($values[$this->getName()]) ){
            foreach ($values[$this->getName()] as $k=>$v){
                $newPrename = $this->getName($prename,true) . "." . $k;
                $this->elementDefinition->validate($v, $data, $newPrename, $cV);
            }
        }
        
        return $validation;
        
    }

    public function getElement($name){
        return $this->elementDefinition;
    }


}