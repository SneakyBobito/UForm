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

    public function isValid(){
        foreach($this->validations as $v){
            if(!$v->isValid())
                return false;
        }
        return true;
    }
}