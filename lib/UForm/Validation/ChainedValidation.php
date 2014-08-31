<?php

namespace UForm\Validation;
use UForm\Validation;

/**
 * ChaineValidation
 *
 * @author sghzal
 */
class ChainedValidation {

    /**
     * @var Validation[]
     */
    protected $validationsName = array();
    protected $validationsInternalName = array();
    
    protected $data;
    
    protected $isValid;
            
    function __construct($data) {
        $this->data = $data;
    }

    
    public function addValidation(\UForm\Validation $validation){
        $el = $validation->getElement();
        if($el->getName()){
            $this->validationsName[$el->getName(true, true)] = $validation;
        }
        $this->validationsInternalName[$validation->getElement()->getInternalName(true)] = $validation;
        
    }

    /**
     * get the validation by its name
     * @param $name
     * @return null|Validation
     */
    public function getValidation($name,$iname=false){

        if($iname){
            if(isset($this->validationsInternalName[$name])){
                return $this->validationsInternalName[$name];
            }
        }else{
            if(isset($this->validationsName[$name])){
                return $this->validationsName[$name];
            }
        }
        
        return null;

    }
    
    public function getValidations() {
        return $this->validationsInternalName;
    }

    
    public function getData() {
        return $this->data;
    }
    
    public function validate(){
        
        $passed = true;
        
        // we init validation before (e.g we init messages to make them ready from everywhere)
        foreach($this->validationsInternalName as $v){
            $v->initValidation();
        }
        
        foreach ($this->validationsInternalName as $v){
            if (false === $v->validate($this->data, $this->data)) {
                $passed = false;
            }
        }
        
        
        $this->isValid = $passed;
        
        return $passed;
        
    }

    public function isValid(){
        return $this->isValid;
    }
}