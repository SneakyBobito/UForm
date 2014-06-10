<?php

namespace UForm\Validation;

/**
 * ChaineValidation
 *
 * @author sghzal
 */
class ChainedValidation {

    protected $validations = array();
    
    public function addValidation($name,  \UForm\Validation $validation){
        $this->validations[$name] = $validation;
    }

    public function getValidation($name){

        if(isset($this->validations[$name])){
            return $this->validations[$name];
        }

        return null;

    }
}