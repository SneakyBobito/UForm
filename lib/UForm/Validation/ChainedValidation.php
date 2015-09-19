<?php

namespace UForm\Validation;

use UForm\Exception;
use UForm\Form\Element;
use UForm\Navigator;
use UForm\Validation;
use UForm\ValidationItem;

/**
 * ChaineValidation
 *
 * @author sghzal
 */
class ChainedValidation
{

    /**
     * @var ValidationItem[]
     */
    protected $validationsName = [];
    /**
     * @var ValidationItem[]
     */
    protected $validationsInternalName = [];
    
    protected $data;
    
    protected $isValid = true;
            
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function addValidation(ValidationItem $validation)
    {
        $el = $validation->getElement();
        if ($el->getName()) {
            $this->validationsName[$el->getName(true, true)] = $validation;
        }
        $this->validationsInternalName[$validation->getElement()->getInternalName(true)] = $validation;
        
    }

    public function getDataFor($element)
    {

        if ($element instanceof Element) {
            $name = $element->getName(true, true);
        } else {
            $name = $element;
        }

        $navigator = new Navigator();
        return $navigator->arrayGet($this->data, $this->data, $name);

    }

    /**
     * get the validation by its name
     * @param $name
     * @return null|ValidationItem
     */
    public function getValidation($name, $iname = false)
    {

        if (!is_string($name)) {
            throw new Exception('Invalid type for parameter $name. String expected, ' . gettype($name) . ' used');
        }

        if ($iname) {
            if (isset($this->validationsInternalName[$name])) {
                return $this->validationsInternalName[$name];
            }
        } else {
            if (isset($this->validationsName[$name])) {
                return $this->validationsName[$name];
            }
        }
        
        return null;

    }
    
    public function getValidations()
    {
        return $this->validationsInternalName;
    }

    
    public function getData()
    {
        return $this->data;
    }
    
    public function validate()
    {
        
        $passed = true;
        
        // we init validation before (e.g we init messages to make them ready from everywhere)
        foreach ($this->validationsInternalName as $v) {
            $v->resetValidation();
        }
        
        foreach ($this->validationsInternalName as $v) {
            if (false === $v->validate($this->data, $this->data)) {
                $passed = false;
            }
        }
        
        
        $this->isValid = $passed;
        
        return $passed;
        
    }

    /**
     * tells if the validation succeeded
     * @return bool
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * Check if an element is valid
     * @param string|Element $name name of the element to check. It can also be the element instance
     * @return bool
     * @throws Exception
     */
    public function elementIsValid($name)
    {

        if ($name instanceof Element) {
            $name = $name->getName(true, true);
        }

        $validation = $this->getValidation($name);
        if (!$validation) {
            throw new Exception('Element with ID='.$name.' is not part of the form');
        }
        return $validation->isValid();
    }

    /**
     * check whether all the children of the element are valid
     * @param string $name
     * @return boolean
     */
    public function elementChildrenAreValid($name)
    {
        $validation = null;
        if (is_string($name)) {
            $validation = $this->getValidation($name);
        } elseif ($name instanceof Element) {
            $validation = $this->getValidation($name->getName(true, true));
        }
        if (!$validation instanceof ValidationItem) {
            throw new Exception("Element not valid for children validation");
        }
        return $validation->childrenAreValid($this);
    }

    /**
     * Get all the messages generated during the validation
     * @return Message\Group
     */
    public function getMessages()
    {
        $messages = new Validation\Message\Group();
        foreach ($this->validationsName as $validation) {
            $messages->appendMessages($validation->getMessages());
        }
        return $messages;
    }
}
