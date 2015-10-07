<?php

namespace UForm\Validation;

use UForm\DataContext;
use UForm\Exception;
use UForm\Form\Element;
use UForm\InvalidArgumentException;
use UForm\Navigator;
use UForm\Validation;

/**
 * ChaineValidation
 *
 * @author sghzal
 */
class ChainedValidation
{

    /**
     * @var string[]
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
        $internalName = $el->getInternalName(true);
        if (null !== $name) {
            $this->validationsName[$el->getName(true, true)] = $internalName;
        }
        $this->validationsInternalName[$internalName] = $validation;

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
     * gets the validation by its internal name
     * @see getValidations()
     * @see getValidationByName()
     * @param string $name internal name of the element or the element instance
     * @return null|ValidationItem the validation item
     * @throws InvalidArgumentException
     */
    public function getValidation($name)
    {
        if (is_object($name) && $name instanceof Element) {
            $name = $name->getInternalName(true);
        } elseif (!is_string($name) && !is_int($name)) {
            throw new InvalidArgumentException("name", "Element instance or string or int", $name);
        }

        if (isset($this->validationsInternalName[$name])) {
            return $this->validationsInternalName[$name];
        }
        return null;
    }

    /**
     * Get an element validation by its public name
     * @see getValidation()
     * @see getValidations()
     * @param string $name public name of the element
     * @return null|ValidationItem
     */
    public function getValidationByName($name)
    {
        if (!is_string($name) && !is_int($name)) {
            throw new InvalidArgumentException("name", "Element instance or string or int", $name);
        }
        if (isset($this->validationsName[$name])) {
            return $this->validationsInternalName[$this->validationsName[$name]];
        }
        return null;
    }

    /**
     * get the validations in the chainedValidation
     * @see getValidation()
     * @see getValidationByName()
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
     *
     * @see isValid()
     *
     * @return bool true if the validation passed
     */
    public function validate()
    {

        // we init validation before (e.g we init messages to make them ready from everywhere)
        foreach ($this->validationsInternalName as $v) {
            $v->resetValidation();
        }

        // We validate everything
        foreach ($this->validationsInternalName as $v) {
            $v->validate();
        }

        // we use an additional loop because we can check valid
        // state only when everything is processed
        // For instance Validator proxy mays set the valid state latter
        $passed = true;
        foreach ($this->validationsInternalName as $v) {
            if (!$v->isValid()) {
                $passed = false;
                break;
            }
        }

        $this->isValid = $passed;

        return $this->isValid;

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
            $validation = $this->getValidationByName($name);
        }


        if (!$validation) {
            throw new Exception('Element with ID='.$name.' is not part of the form');
        }
        return $validation->isValid();
    }

    /**
     * check whether all the children of the element are valid
     * @param string|Element $name internal name or instance of the element
     * @return boolean
     * @throws Exception
     */
    public function elementChildrenAreValid($name)
    {
        $validation = null;
        if (is_string($name) || $name instanceof Element) {
            $validation = $this->getValidation($name);
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
        foreach ($this->validationsInternalName as $validation) {
            $messages->appendMessages($validation->getMessages());
        }
        return $messages;
    }
}
