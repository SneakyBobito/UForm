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

    protected $data;

    function __construct($form, $data = [], $chainValidation = null)
    {
        $this->form = $form;
        $this->chainValidation = $chainValidation;
        $this->data = $data;
    }


    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    public function getData(){
        return $this->data;
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

}