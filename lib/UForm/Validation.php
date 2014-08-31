<?php
/**
 * Validation
 *
 * @author Andres Gutierrez <andres@phalconphp.com>
 * @author Eduar Carvajal <eduar@phalconphp.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @version 1.2.6
 * @package Phalcon
*/
namespace UForm;

use 
	\UForm\Validation\Exception,
	\UForm\Validation\Message\Group,
	\UForm\Validation\ChainedValidation;

/**
 * Phalcon\Validation
 *
 * Allows to validate data using validators
 */
class Validation
{
	/**
	 * Data
	 * 
	 * @var null|array|object
	 * @access protected
	*/
	protected $_dataLocal = null;

        /**
         *
         * @var Forms\Element
         */
        protected $_element;
        
        /**
	 * Entity
	 * 
	 * @var null|object
	 * @access protected
	*/
	protected $_entity = null;

	/**
	 * Filters
	 * 
	 * @var \UForm\Filter[]
	 * @access protected
	*/
	protected $_filters = null;

	/**
	 * Messages
	 * 
	 * @var null|\UForm\Validation\Message\Group
	 * @access protected
	*/
	protected $_messages = null;

        
        protected $_value = null;
        
        protected $_valid = false;

    
        
        /**
         *
         * @var ChainedValidation
         */
        protected $chainedValidation;


    /**
     * \UForm\Validation constructor
     *
     * @param name with dotted syntaxe
     * @throws Exception
     */
    public function __construct($elements , $localData , ChainedValidation $cV)
    {
        $this->chainedValidation = $cV;
        $this->_element = $elements;

        $this->_dataLocal = $localData;

    }
        

    public function getLocalData() {
        return $this->_dataLocal;
    }

    public function getLocalName() {
        return $this->_element->getName();
    }

    public function getElement() {
        return $this->_element;
    }

            
 

    public function getChainedValidation() {
        return $this->chainedValidation;
    }        

    public function initValidation(){

        //Clear pre-calculated values
        $this->_values = null;
        $this->_valid = true;

        $this->_messages = new Group();

    }
        
    /**
     * Validate a set of data according to a set of rules
     *
     * @param array|object|null $data
     * @return \UForm\Validation\Message\Group|boolean|null
     * @throws Exception
     */
    public function validate( $localValues ){
        
        $validators = $this->_element->getValidators();
        if(is_array($validators)){
            foreach($validators as $v) {
                if( false === $v->validate($this) ) {
                    
                    $this->_valid = false;
                    if($v->getOption('cancelOnFail') === true) {
                        break;
                    }
                    
                }
            }
        }
        return $this->_valid;
    }

    public function isValid(){
        return $this->_valid == true;
    }

    /**
     * Adds a validator to a field
     *
     * @param string $attribute
     * @param \UForm\Validation\ValidatorInterface
     * @return \UForm\Validation
     * @throws Exception
     */
    public function add(Validation\Validator $validator){
            if( !is_array($this->_validators) ) {
                $this->_validators = array();
            }

            $this->_validators[] = $validator;
    }

    /**
     * Adds filters to the field
     *
     * @param string $attribute
     * @param array|string $filters
     * @return \UForm\Validation
     * @throws Exception
     */
    public function setFilters($filters)
    {

        $this->_filters = $filters;
    }

    /**
     * Returns all the filters or a specific one
     *
     * @param string|null $attribute
     * @return null|array|string
     */
    public function getFilters(){
        return $this->_filters;
    }

    /**
     * Returns the validators added to the validation
     *
     * @return array|null
     */
    public function getValidators()
    {
            return $this->_validators;
    }



    /**
     * Returns the registered validators
     *
     * @return \UForm\Validation\Message\Group|null
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Appends a message to the messages list
     *
     * @param \UForm\Validation\MessageInterface $message
     * @return \UForm\Validation
     */
    public function appendMessage($message,$elementName = null){

        if(null == $elementName){
            $this->_messages->appendMessage($message);
        }else{

            $v = $this->chainedValidation->getValidation($elementName);
            if(!$v){
                throw new \Uform\Forms\Exception('Unable to append message : element with ID='.$elementName.' is not part of the form.');
            }
            $v->appendMessage($message);
        }

        return $this;
    }


    /**
     * Gets the value to validate in the array/object data source
     *
     * @param string $attribute
     * @return mixed
     * @throws Exception
     */
    public function getValue($name = null)
    {

        if(null === $name){
            $name = $this->getElement()->getName();
            $value = $this->getLocalData();
            $value = isset($value[$name]) ? 
                    $value[$name] 
                  : null;
            $filters = $this->getFilters();

        }else{
            if($name{0} === ".")
                // we need to get element from the root,
                // form->getValidation is not aware of localScope
                $scopedAttribute = $this->getElement()->getName(true, true) . $name;
            else
                $scopedAttribute = $name;

            $validation = $this->chainedValidation->getValidation($scopedAttribute);

            $value   = $validation->getValue();
            $filters = $validation->getFilters();
        }  

        if( !is_null($value) ) {
            if( is_array($filters)) {
                foreach($filters as $f){
                    $value = $f->filter($value);
                }
            }
            return $value;
        }

        return null;
    }
}
