<?php
/**
 * Form
*/
namespace UForm\Forms;

use 
	\Countable,
	\Iterator,
	\UForm\Forms\Exception,
	\UForm\Forms\ElementInterface,
	\UForm\Validation,
	\UForm\Validation\Message\Group,
        UForm\Forms\Element\Group as ElementGroup;
use UForm\Navigator;

/**
 * UForm\Forms\Form
 *
 * This component allows to build forms using an object-oriented interface
 * @semanticType form
 */
class Form extends ElementGroup {

    /**
     * Data
     * 
     * @var null|array
     * @access protected
    */
    protected $_data;


    /**
     * @var Validation\ChainedValidation
     */
    protected $chainedValidation;

    /**
     * Messages
     * 
     * @var null|array
     * @access protected
    */
    protected $_messages;
    
    protected $_action;
    protected $_method ="post";


    /**
     * \Phalcon\Forms\Form constructor
     *
     * @param object|null $entity
     * @param array|null $userOptions
     * @throws Exception
     */
    public function __construct()
    {
        $this->_form = $this;
        parent::__construct();
        $this->addSemanticType("form");
    }

    public function add(Element $element) {
        parent::addElement($element);
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
     * @return \UForm\Forms\Form
     * @throws Exception
     */
    public function bind($entity , $data = null, $whitelist = null)
    {

        if(null == $data)
            $data = $this->getData ();

        if(is_array($data) === false) {
            throw new Exception('The data must be an array');
        }

        if(is_object($entity) === false) {
            throw new Exception('Invalid parameter type.');
        }

        if(is_array($whitelist) === false &&
            is_null($whitelist) === false) {
            throw new Exception('Invalid parameter type.');
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

            //Use the setter if available
            $method = 'set'.$key;
            if(method_exists($entity, $method) === true) {
                call_user_func(array($entity, $method), $value);
            }else{
                //Use the public property if it doesn't have a setter
                $entity->$key = $value;
            }

        }
    }
        
    /**
     * set the data to the form
     * @param array $data dataset to fill/validate the form
     * @return \UForm\Forms\Form fluent : returns itself
     */
    public function setData($data){
        $this->_data = $data;
        $this->chainedValidation = null;
        return $this;
    }

    
    public function mergeData($data){
        $this->_data = array_merge_recursive($this->_data,$data);
        return $this;
    }
    
    public function insertData($data){
        $this->_data = array_merge_recursive($data,  $this->_data);
        return $this;
    }
    
    /**
     * validates the form using either the data given in parameter or either the data set with setData method
     * @var array|null $data the data used for the validation. If ommited the method will try to get the last data set with setData method
     * @return FormContext
     */
    public function validate($inputData = null){

        $data = is_array($this->_data) ? $this->_data : array();

        $validation = new Validation\ChainedValidation($data);
        $this->chainedValidation = $validation;
        $this->prepareValidation($validation->getData() , $validation);
        $this->_isValid = $validation->validate();
        return new FormContext($this, $validation);
    }


    /**
     * A shortcut to check validation of the last call to validate method
     * @return bool
     */
    public function formIsValid(){

        if(!$this->chainedValidation) {
            return true;
        }
        
        return $this->chainedValidation->isValid();
    }


    /**
     * get the last validation generated with validate method
     * @param string $name
     * @return Validation
     * @throws Exception
     */
    public function getValidation($name = null){
        if (null == $name) {
            return $this->chainedValidation;
        }
        $validation =$this->chainedValidation->getValidation($name);
        if(!$validation){
            throw new Exception('Element with ID='.$name.' is not part of the form');
        }
        return $validation;
    }


	/**
	 * Renders a specific item with the current form context
	 *
	 * @param string $name
	 * @param array|null $attributes
	 * @return string
	 * @throws Exception
	 */
    public function renderElement($name, $attributes = null){

        $n = null;
        if(is_string($name)) {
            $n = new Navigator();
            $element = $n->formGet($this,$name);
        }else if(is_object($name) && $name instanceof Element){
            $element = $name;
            $name = $element->getName(true,true);
        }else{
            throw new Exception('The form::renderElement() 1st param must be a string or Element instance');
        }


        if( strpos($name,".") > 1){
            if(!$n){
                $n = new Navigator();
            }
            $prename = substr($name, 0, strrpos( $name, '.') );
            $localValue = $n->arrayGet($this->getData(),$this->getData(),$name,1);
        }else{
            $prename = null;
            $localValue = $this->getData() ;
        }


        if(!$element){
            throw new Exception('Element with ID=' . $name . ' is not part of the form');
        }

        return $element->render($attributes , $localValue , $this->getData() , $prename);
    }


    /**
     * Check if an element is valid using the current form context
     * @param string $name name of the element to check
     * @return bool
     * @throws Exception
     */
    public function elementIsValid($name){
        if (!$this->chainedValidation) {
            return true;
        }
        return $this->chainedValidation->elementIsValid($name);
    }
    
    /**
     * check whether all the children of the element are valid
     * @param string $name
     * @return boolean
     */
    public function elementChildrenAreValid($name){
        if(!$this->chainedValidation){
            return true;
        }
        return $this->elementChildrenAreValid($name);
    }

    /**
     * get the message list for the given element name
     * @param $name
     * @return bool|null|Group
     * @throws Exception
     */
    public function getElementMessages($name){

        if (!$this->chainedValidation) {
            return array();
        }

        $validation =$this->chainedValidation->getValidation($name);

        if(!$validation){
            throw new Exception('Element with ID='.$name.' is not part of the form');
        }

        return $validation->getMessages();
    }

    /**
     * Alias pour getElement()
     * @param string $name
     * @return Element
     */
    public function get($name)
    {
        return $this->getElement($name);
    }

	

    /**
     * Gets a value from the internal related entity or from the default value
     *
     * @param string $name
     * @return mixed
     * @throws Exception
     */
     public function getValue($name)
     {
        if(is_string($name) === false) {
            throw new Exception('Invalid parameter type.');
        }

        if(is_array($this->_data) === true) {
            //Check if the data is in the data array
            if(isset($this->_data[$name]) === true) {
                return $this->_data[$name];
            }
        }
        return null;
     }
     
     /**
      * get the data in the form
      * @return type
      */
     public function getData(){
        return $this->_data;
     }


}