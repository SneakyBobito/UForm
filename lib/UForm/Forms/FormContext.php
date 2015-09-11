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
    protected $validation;




    public function isValid(){
        $this->validation->isValid();
    }

    public function elementIsValid($elementName){

    }

}