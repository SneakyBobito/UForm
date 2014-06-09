<?php

namespace UForm\Validation;

/**
 * ChaineValidation
 *
 * @author sghzal
 */
class ChainedValidation {

    protected $validations = array();
    
    public function addValidation($name,  UForm\Validation $validation){
        $this->validations[$name] = $validation;
    }
    
}