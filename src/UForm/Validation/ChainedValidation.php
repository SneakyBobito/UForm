<?php

namespace UForm\Validation;

use UForm\DataContext;
use UForm\Exception;
use UForm\Form\Element;
use UForm\InvalidArgumentException;
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

    /**
     * @var DataContext
     */
    protected $data;

    protected $isValid = true;

    public function __construct(DataContext $data)
    {
        $this->data = $data;
    }

    /**
     * Adds a validationItem to the internal validation list
     * @param ValidationItem $validation
     */
    public function addValidation(ValidationItem $validation)
    {
        $el = $validation->getElement();
        $name = $el->getName();
        if (null !== $name) {
            $this->validationsName[$el->getName(true, true)] = $validation;
        }
        $this->validationsInternalName[$validation->getElement()->getInternalName(true)] = $validation;

    }

    /**
     * Get the data for an element in the chained validation
     * @param $element
     * @return null
     */
    public function getDataFor($element)
    {
        $data = $this->data->getDataCopy();
        if (!is_array($data)) {
            return null;
        }

        if ($element instanceof Element) {
            $name = $element->getName(true, true);
        } else {
            $name = $element;
        }

        $navigator = new Navigator();
        return $navigator->arrayGet($data, $name);

    }

    /**
     * gets the validation by its name
     * @param string $name name of the validation
     * @param bool $iname default the function will search for the real name of the element, passe $iname to true
     * to search by its internalName
     * @return null|ValidationItem the validation item
     * @throws InvalidArgumentException
     */
    public function getValidation($name, $iname = false)
    {

        if (!is_string($name) && !is_int($name)) {
            throw new InvalidArgumentException("name", "string or int", $name);
        }

        if ($iname) {
            if (isset($this->validationsInternalName[$name])) {
                return $this->validationsInternalName[$name];
            }
        } elseif (isset($this->validationsName[$name])) {
            return $this->validationsName[$name];
        }

        return null;

    }

    /**
     * get the validations in the chainedValidation
     * @return ValidationItem[]
     */
    public function getValidations()
    {
        return array_values($this->validationsInternalName);
    }

    /**
     * Gets the internal data
     * @return DataContext
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Starts to validate every validation.
     * No filtering is made. All filtering should be made before setting the data
     * @return bool true if the validation passed
     */
    public function validate()
    {

        $passed = true;

        // we init validation before (e.g we init messages to make them ready from everywhere)
        foreach ($this->validationsInternalName as $v) {
            $v->resetValidation();
        }

        foreach ($this->validationsInternalName as $v) {
            if (false === $v->validate()) {
                $passed = false;
            }
        }


        $this->isValid = $passed;

        return $passed;

    }

    /**
     * tells if the validation succeeded
     * isValid will always return true before we call validate()
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
            $name = $name->getInternalName(true);
            $validation = $this->getValidation($name, true);
        } else {
            $validation = $this->getValidation($name);
        }


        if (!$validation) {
            throw new Exception('Element with ID='.$name.' is not part of the form');
        }
        return $validation->isValid();
    }

    /**
     * check whether all the children of the element are valid
     * @param string|Element $name
     * @return boolean
     */
    public function elementChildrenAreValid($name)
    {
        $validation = null;
        if (is_string($name)) {
            $validation = $this->getValidation($name);
        } elseif ($name instanceof Element) {
            $validation = $this->getValidation($name->getInternalName(true), true);
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
