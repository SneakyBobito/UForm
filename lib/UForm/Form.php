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

    const METHOD_POST = "POST";
    const METHOD_GET = "GET";
    const ENCTYPE_MULTIPART_FORMDATA = "multipart/form-data";

    protected $action;
    protected $method;
    protected $enctype;

    /**
     * @param string $action form action
     * @param string $method form method
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
        }else{
            $this->setMethod(self::METHOD_POST);
        }
    }

    
    
    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getEnctype()
    {
        return $this->enctype;
    }

    /**
     * @param mixed $enctype
     */
    public function setEnctype($enctype)
    {
        $this->enctype = $enctype;
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
     * Binds data to the entity.
     * It does not apply the filter if you want to apply form filters please use sanitizeData instead
     *
     * @see sanitizeData();
     *
     * @param object $entity
     * @param array $data
     * @param array|null $whitelist
     * @return \UForm\Form
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

        if(!is_array($whitelist)  && !is_null($whitelist)) {
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

            $entity->$key = $value;
        }
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