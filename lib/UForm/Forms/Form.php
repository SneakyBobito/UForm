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
use UForm\RenderContext;

/**
 * UForm\Forms\Form
 *
 * This component allows to build forms using an object-oriented interface
 * 
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


    /**
     * \Phalcon\Forms\Form constructor
     *
     * @param object|null $entity
     * @param array|null $userOptions
     * @throws Exception
     */
    public function __construct()
    {
        if(method_exists($this, 'initialize') === true) {
                $this->initialize();
        }
        
        $this->_form = $this;
    }

    public function add(Element $element) {
        parent::addElement($element);
    }

            /**
     * Binds data to the entity
     *
     * @param array $data
     * @param object $entity
     * @param array|null $whitelist
     * @return \Phalcon\Forms\Form
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
        
    public function setData($data){
        $this->_data = $data;
        $this->chainedValidation = null;
    }

    public function validate(){
        $validation = new Validation\ChainedValidation(is_array($this->_data) ? $this->_data : array());
        $this->chainedValidation = $validation;
        $this->prepareValidation($validation->getData() , $validation);
        $this->_isValid = $validation->validate();
        return $validation;
    }


    public function formIsValid(){
 
        if(!$this->chainedValidation)
            $this->validate ();
        
        return $this->chainedValidation->isValid();
    }


    /**
     *
     * @param type $name
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
	 * Renders a specific item with the form context
	 *
	 * @param string $name
	 * @param array|null $attributes
	 * @return string
	 * @throws Exception
	 */
    public function renderElement($name, $attributes = null)
    {
        if(is_string($name) === false) {
            throw new Exception('The name must be a string');
        }

        $n = new Navigator();
        $element = $n->formGet($this,$name);


        if( strpos($name,".") > 1){
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
     * true if the element is valid
     * @param $name
     * @return bool
     * @throws Exception
     */
    public function elementIsValid($name){

        if (!$this->chainedValidation) {
            return true;
        }

        $validation =$this->chainedValidation->getValidation($name);

        if(!$validation){
            throw new Exception('Element with ID='.$name.' is not part of the form');
        }

        return $validation->isValid();
    }
    
    public function elementChildrenAreValid($name){
        
        if(is_object($name) && $name instanceof Element){
            $name = $name->getName(true, true);
        }

        if (!$this->chainedValidation) {
            return true;
        }
        
        $validation = $this->chainedValidation->getValidation($name);

        if(!$validation){
            return true;
        }
        
        return $validation->getElement()->childrenAreValid($this->chainedValidation);
        
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
        }

        public function getData(){
           return $this->_data;
        }


}