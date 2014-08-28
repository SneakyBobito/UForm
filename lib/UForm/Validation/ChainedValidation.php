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
    protected $validations = array();
    
    protected $data;
    
    protected $isValid;
            
    function __construct($data) {
        $this->data = $data;
    }

    
    public function addValidation($name,  \UForm\Validation $validation){
        $this->validations[$name] = $validation;
    }

    /**
     * get the validation by its name
     * @param $name
     * @return null|Validation
     */
    public function getValidation($name){

        if(isset($this->validations[$name])){
            return $this->validations[$name];
        }

        return null;

    }
    
    public function getValidations() {
        return $this->validations;
    }

    
    public function getData() {
        return $this->data;
    }
    
    public function validate(){
        
        $passed = true;
        
        // we init validation before (e.g we init messages to make them ready from everywhere)
        foreach($this->validations as $v){
            $v->initValidation();
        }
        
        foreach ($this->validations as $v){
            if(!$v->validate($this->data,  $this->data))
                $passed = false;
        }
        
        
        $this->isValid = $passed;
        
        return $passed;
        
    }

    public function isValid(){
        return $this->isValid;
    }
}