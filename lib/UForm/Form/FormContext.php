<?php

namespace UForm\Form;

use UForm\DataContext;
use UForm\Form;
use UForm\Validation\ChainedValidation;

class FormContext {

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var DataContext
     */
    protected $data;

    /**
     * @var ChainedValidation
     */
    protected $chainValidation;

    function __construct($form, DataContext $data)
    {
        $this->form = $form;
        $this->data = $data;
        $this->chainValidation = new ChainedValidation($data);
    }

    /**
     * @return ChainedValidation
     */
    public function getChainedValidation()
    {
        return $this->chainValidation;
    }

    public function validate(){
        $this->form->prepareValidation($this->data, $this);
        $this->chainValidation->validate();
        return $this->chainValidation->isValid();
    }

    /**
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     *
     * @return DataContext
     */
    public function getData(){
        return $this->data;
    }

    public function isValid(){
        return $this->chainValidation->isValid();
    }

    public function elementIsValid($elementName){
        return $this->chainValidation->elementIsValid($elementName);
    }

    public function childrenAreValid($elementName){
        return $this->chainValidation->elementChildrenAreValid($elementName);
    }

    public function getValueFor($name){
        return $this->getData()->findValue($name);
    }

}