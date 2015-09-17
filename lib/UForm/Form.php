<?php

namespace UForm;

use UForm\Form\Element\Container\Group as ElementGroup;
use UForm\Form\Exception;
use UForm\Form\FormContext;
use UForm\Navigator;
use UForm\Validation;

/**
 * UForm\Form\Form
 *
 * This component allows to build forms using an object-oriented interface
 * @semanticType form
 */
class Form extends ElementGroup {


    protected $_action;
    protected $_method = "post";

    /**
     *
     * @param object|null $entity
     * @param array|null $userOptions
     * @throws Exception
     */
    public function __construct($action = null, $method = null)
    {
        $this->_form = $this;
        parent::__construct();
        $this->addSemanticType("form");

        if($action){
            $this->setAction($action);
        }
        if($method){
            $this->setMethod($method);
        }

    }

    
    
    public function getAction() {
        return $this->_action;
    }

    public function setAction($_action) {
        $this->_action = $_action;
    }

    public function getMethod() {
        return $this->_method;
    }

    public function setMethod($_method) {
        $this->_method = $_method;
    }

    
    /**
     * Binds data to the entity
     *
     * @param array $data
     * @param object $entity
     * @param array|null $whitelist
     * @return \UForm\Form\Form
     * @throws Exception
     */
    public function bind($entity , $data , $whitelist = null)
    {

        if(is_array($data) === false) {
            throw new Exception('The data must be an array');
        }

        if(is_object($entity) === false) {
            throw new Exception('Invalid parameter type.');
        }

        if(is_array($whitelist) === false &&
            is_null($whitelist) === false) {
            throw new Exception('Invalid type for whitelist.');
        }

        if(is_array($this->getElements()) === false) {
            throw new Exception('There are no elements in the form');
        }

        foreach($data as $key => $value) {

            $element = $this->getElement($key);

            if(!$element) {
                continue;
            }

            //Check if the item is in the whitelist
            if(is_array($whitelist) === true && !in_array($key, $whitelist)) {
                continue;
            }

            //Apply filters
            $filters = $element->getFilters();
            if(is_array($filters)) {
                foreach ($filters as $filter){
                    $value = $filter->filter($value);
                }
            }

            $entity->$key = $value;
        }
    }

    /**
     * validates the form using either the data given in parameter or either the data set with setData method
     * @var array|null $data the data used for the validation. If ommited the method will try to get the last data set with setData method
     * @return FormContext
     */
    public function validate($inputData){
        $formContext = $this->generateContext($inputData);
        $formContext->validate();
        return $formContext;
    }

    /**
     * Generate a form context with the given data
     * @param null $data
     * @return FormContext
     */
    public function generateContext($data = null){
        if(null === $data){
            $data = new DataContext([]);
        }else {
            $data = new DataContext($this->sanitizeData($data));
        }

        $formContext = new FormContext($this, $data);
        return $formContext;
    }
}