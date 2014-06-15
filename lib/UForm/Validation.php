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
	\UForm\FilterInterface;

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
	protected $_data      = null;
	protected $_dataLocal = null;

        protected $_localName = null;
        protected $_globalName = null;

        /**
	 * Entity
	 * 
	 * @var null|object
	 * @access protected
	*/
	protected $_entity = null;

	/**
	 * Validators
	 * 
	 * @var null|array
	 * @access protected
	*/
	protected $_validators = null;

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
	 * \UForm\Validation constructor
	 *
         * @param name with dotted syntaxe
	 * @param array|null $validators
	 * @throws Exception
	 */
	public function __construct($localName , $globalName , $validators = null)
	{
            
            $this->_localName = $localName;
            $this->_globalName = $globalName;
            
            if(is_null($validators) === false && is_array($validators) === false) {
                throw new Exception('Validators must be an array');
            }

            $this->_validators = $validators;

            if(method_exists($this, 'initialize') === true) {
                $this->initialize();
            }
	}
        


        
	/**
	 * Validate a set of data according to a set of rules
	 *
	 * @param array|object|null $data
	 * @return \UForm\Validation\Message\Group|boolean|null
	 * @throws Exception
	 */
	public function validate( $values , $data ){


            //Clear pre-calculated values
            $this->_values = null;
            
            $this->_valid = true;
            
            $messages = new Group();

            $this->_messages = $messages;
            if( is_array($data) ) {
                $this->_data = $data;
            }
            
            if( is_array($values) ) {
                $this->_dataLocal = $values;
            }

            if(is_array($this->_validators)){
                //Validate
                foreach($this->_validators as $scope) {

                    if(is_object($scope[1]) === false) {
                        throw new Exception('One of the validators is not valid');
                    }

                    if( !$scope[1]->validate($this) ) {

                        $this->_valid = false;

                        if($scope[1]->getOption('cancelOnFail') === true) {
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
	public function add($attribute, $validator)
	{
		if(is_string($attribute) === false) {
                    throw new Exception('The attribute must be a string');
		}

		if(is_object($validator) === false) {
                    throw new Exception('The validator must be an object');
		}

		if( !is_array($this->_validators) ) {
                    $this->_validators = array();
		}

		$this->_validators[] = array($attribute, $validator);
	}

	/**
	 * Adds filters to the field
	 *
	 * @param string $attribute
	 * @param array|string $filters
	 * @return \UForm\Validation
	 * @throws Exception
	 */
	public function setFilters($attribute, $filters)
	{
            if(is_string($attribute) === false) {
                throw new Exception('Invalid parameter type.');
            }

            if(is_array($attribute) === false && is_string($attribute) === false) {
                throw new Exception('Invalid parameter type.');
            }

            $this->_filters[$attribute] = $filters;
	}

	/**
	 * Returns all the filters or a specific one
	 *
	 * @param string|null $attribute
	 * @return null|array|string
	 */
	public function getFilters($attribute = null)
	{
            if(is_string($attribute) === true) {
                if(isset($this->_filters[$attribute]) === true) {
                    return $this->_filters[$attribute];
                }

                return null;
            }

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
	public function appendMessage($message)
	{
            //@note the type check is not implemented in the original source code
            if(is_null($this->_messages) === false) {
                $this->_messages->appendMessage($message);
            }

            return $this;
	}

	/**
	 * Assigns the data to an entity
	 * The entity is used to obtain the validation values
	 *
	 * @param object $entity
	 * @param object|array $data
	 * @return \UForm\Validation
	 * @throws Exception
	 */
	public function bind($entity, $data)
	{
            if(is_object($entity) === false) {
                    throw new Exception('The entity must be an object');
            }

            if(is_array($data) === false && is_object($data) === false) {
                    throw new Exception('The data to validate must be an array or object');
            }

            $this->_entity = $entity;
            $this->_data = $data;

            return $this;
	}
        
        public function getLocalName() {
            return $this->_localName;
        }

        public function getGlobalName() {
            return $this->_globalName;
        }

        public function getGlobalData() {
            return $this->_data;
        }

        public function getLocalData() {
            return $this->_dataLocal;
        }

                
        
	/**
	 * Gets the value to validate in the array/object data source
	 *
	 * @param string $attribute
	 * @return mixed
	 * @throws Exception
	 */
	public function getValue($attribute = null)
	{
            
            if(null == $attribute)
                $attribute = $this->_localName;
            
            if(is_object($this->_entity) === true) {
                $method = 'get'.$attribute;
                if(method_exists($this->_entity, $method) === true) {
                        return call_user_method($method, $this->_entity);
                } elseif(method_exists($this->_entity, 'readattribute') === true) {
                        return $this->_entity->readattribute($attribute);
                } elseif(property_exists($this->_entity, $attribute) === true) {
                        return $this->_entity->$attribute;
                } else {
                        return null;
                }
            }
            
            //Check if there is a calculated value
            if(isset($this->_values[$attribute]) === true) {
                return $this->_values[$attribute];
            }

            if( is_array($this->_data) ) {
                if( isset($this->_data[$attribute]) ) {
                    $value = $this->_data[$attribute];
                }else{
                    $value = null;
                }
            } elseif( is_object($this->_data) ) {
                if(property_exists($this->_data, $attribute) === true) {
                    $value = $this->_data->$attribute;
                }else{
                    $value = null;
                }
            } else {
                throw new Exception('There is no data to validate');
            }

            if( !is_null($value) ) {
                if( is_array($this->_filters) && isset($this->_filters[$attribute]) ) {

                    foreach($this->_filters[$attribute] as $f){
                        $value = $f->filter($value);
                    }
                }

                //Cache the calculated value
                $this->_values[$attribute] = $value;
                return $value;
                
                return $value;
            }

            return null;
	}
}