<?php

namespace UForm\Validation;
use UForm\Forms\Element;
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
    public function getValidation($name, $iname=false){

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

    /**
     * Check if an element is valid
     * @param string $name name of the element to check
     * @return bool
     * @throws Exception
     */
    public function elementIsValid($name){

        $validation = $this->getValidation($name);
        if(!$validation){
            throw new Exception('Element with ID='.$name.' is not part of the form');
        }
        return $validation->isValid();
    }

    /**
     * check whether all the children of the element are valid
     * @param string $name
     * @return boolean
     */
    public function elementChildrenAreValid($name){
        $element = null;
        if(is_string($name)){
            $validation = $this->getValidation($name);
            if($validation){
                $element = $validation->getElement();
            }
        }else{
            $element = $name;
        }
        if (!$element instanceof Element) {
            throw new Exception("Element not valid for children validation");
        }
        return $element->childrenAreValid($this);
    }
}