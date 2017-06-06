<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form;

use UForm\DataContext;
use UForm\Form;
use UForm\Validation\ChainedValidation;

/**
 * @covers UForm\Form\FormContext
 */
class FormContext
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var DataContext
     */
    protected $data;

    /**
     * @var DataContext
     */
    protected $originalData;

    /**
     * @var ChainedValidation
     */
    protected $chainValidation;

    public function __construct($form, DataContext $data, DataContext $originalData)
    {
        $this->form = $form;
        $this->data = $data;
        $this->originalData = $originalData;
        $this->chainValidation = new ChainedValidation($data);
        $this->form->prepareValidation($this->data, $this);
    }

    /**
     * Get the internal chained validation item
     * @return ChainedValidation
     */
    public function getChainedValidation()
    {
        return $this->chainValidation;
    }

    /**
     * validates the formContext
     * A form context will be always valid before being validated.
     * Additionally a form context generated with $form->validate will already be validated
     * @return bool true if the data are valid
     */
    public function validate()
    {
        $this->chainValidation->validate();
        return $this->chainValidation->isValid();
    }

    /**
     * Get the form that the formContext represents
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Gets the data of the form context
     * @return DataContext
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Gets the original data of the form context (non filtered data)
     * @return DataContext
     */
    public function getOriginalData()
    {
        return $this->originalData;
    }

    /**
     * Check if the form context is valid
     * A form context will always be valid before being validate
     * @return bool
     */
    public function isValid()
    {
        return $this->chainValidation->isValid();
    }

    /**
     * Get all the messages generated during the validation
     * @return \UForm\Validation\Message\Group
     */
    public function getMessages()
    {
        return $this->chainValidation->getMessages();
    }

    /**
     * Check if an element is valid
     * A element will always be valid before the formContext is validated
     * @param string|Element $elementName
     * @return bool
     * @throws \UForm\Exception
     */
    public function elementIsValid($elementName)
    {
        return $this->chainValidation->elementIsValid($elementName);
    }

    /**
     * Check if children of an element are valid
     * Element's children will always be valid before the formContext is validated
     * @param string|Element $elementName public name of the element or instance of the element
     * @return bool
     * @throws \UForm\Exception
     */
    public function childrenAreValid($elementName)
    {

        if (is_string($elementName)) {
            $validation = $this->chainValidation->getValidationByName($elementName);
            if ($validation) {
                return $validation->childrenAreValid();
            } else {
                return true;
            }
        } else {
            return $this->chainValidation->elementChildrenAreValid($elementName);
        }
    }

    /**
     * Get the value of an element
     * @param $name
     * @return mixed
     */
    public function getValueFor($name)
    {
        return $this->getData()->findValue($name);
    }


    /**
     * Get the value of an element
     * @param $name
     * @return mixed
     */
    public function getOriginalValueFor($name)
    {
        return $this->getOriginalData()->findValue($name);
    }



    /**
     * bind the given objet or array with the data of the form context
     * @param $entity
     * @param array $whiteList
     */
    public function bind(&$entity, $whiteList = null)
    {
        $this->form->bind($entity, $this->getData()->getDataCopy(), $whiteList);
    }
}
