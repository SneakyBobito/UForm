<?php

namespace UForm\Forms\Element;

use UForm\Validation\ChainedValidation,
    UForm\Forms\Exception
    ;
use UForm\Forms\ElementContainer;

/**
 * Collection
 *
 * @author sghzal
 */
class Group extends ElementContainer{
    
    /**
     * @var \UForm\Forms\ElementInterface[]
     */
    protected $elements;

    public function __construct($name=null, $elements = null) {
        parent::__construct($name);
        
        if(is_array($elements)){
            foreach ($elements as $el){
                $this->elements[] = $el;
            }
        }else if(is_object ($elements)){
            $this->elements[] = $elements;
        }
        
    }
    
    public function addElement(\UForm\Forms\ElementInterface $element){
        $this->elements[] = $element;
    }
    
    public function getName($prename = null, $dottedNotation = false) {
        if(null === $this->_name)
            return $prename;
            
        return parent::getName($prename, $dottedNotation);
    }

    public function _render( $attributes , $values , $data , $prename = null ) {
        $render = "";
        
        foreach($this->elements as $v){
            $newPrename = $this->getName($prename);
            $hasName = null !== $this->_name ;
            
            if($hasName)
                $render .= $v->render( isset($attributes[$v->getName()]) ? $attributes[$v->getName()] : null , $values[$this->getName()] , $data, $newPrename);
            else
                $render .= $v->render( isset($attributes[$v->getName()]) ? $attributes[$v->getName()] : null , $values , $data, $newPrename);
        }
        
        return $render;
    }

    public function getElement($name){
        foreach($this->elements as $elm){
            if( $name == $elm->getName()){
                return $elm;
            }
        }

        $availNames =  array();
        foreach($this->elements as $elm){
            $availNames[] = $elm->getName();
        }


        throw new Exception('Element with ID=' . $name . ' is not part of the Group. Availables : [' . implode(",",$availNames) . ']' );
    }


    public function getElements(){
        return $this->elements;
    }


    public function prepareValidation($localValues,  ChainedValidation $cV , $prename = null){
        
        parent::prepareValidation($localValues, $cV, $prename);
        
        $localValues = (array) $localValues;
        
        foreach ($this->elements as $k=>$v){
            $newPrename = $this->getName($prename,true);
            $v->prepareValidation(isset($localValues[$this->getName()]) ? $localValues[$this->getName()] : null, $cV, $newPrename);
        }
        
    }

}
