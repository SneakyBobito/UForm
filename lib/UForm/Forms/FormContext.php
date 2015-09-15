<?php

namespace UForm\Forms;


use UForm\Validation\ChainedValidation;

class FormContext {

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var ChainedValidation
     */
    protected $chainValidation;

    function __construct($form, $chainValidation = null)
    {
        $this->form = $form;
        $this->chainValidation = $chainValidation;
    }


    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    public function getData(){
        if(!$this->chainValidation){
            return [];
        }
        return $this->chainValidation->getData();
    }

    public function isValid(){
        if(!$this->chainValidation){
            return true;
        }
        return $this->chainValidation->isValid();
    }

    public function elementIsValid($elementName){
        if(!$this->chainValidation){
            return true;
        }
        return $this->chainValidation->elementIsValid($elementName);
    }

    public function childrenAreValid($elementName){
        if(!$this->chainValidation){
            return true;
        }
        return $this->chainValidation->elementChildrenAreValid($elementName);
    }

    public function getLocalValue(){
        if(!$this->chainValidation){
            return null;
        }

    }

}