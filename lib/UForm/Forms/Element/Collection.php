<?php

namespace UForm\Forms\Element;

use UForm\Forms\Element

;

/**
 * Collection
 *
 * @author sghzal
 */
class Collection extends Element{
    
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
    
}