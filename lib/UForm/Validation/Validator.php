<?php
/**
 * Validator
 *
 * @author Andres Gutierrez <andres@phalconphp.com>
 * @author Eduar Carvajal <eduar@phalconphp.com>
 * @author Wenzel Pünter <wenzel@phelix.me>
 * @version 1.2.6
 * @package Phalcon
*/
namespace UForm\Validation;

use \UForm\Validation\Exception;

/**
 * Phalcon\Validation\Validator
 *
 * This is a base class for validators
 */
abstract class Validator
{
    /**
     * Options
     * 
     * @var null
     * @access protected
    */
    protected $_options;

    /**
     * \UForm\Validation\Validator constructor
     *
     * @param array|null $options
     * @throws Exception
     */
    public function __construct($options = null)
    {
        $this->_options = $options;

    }

    /**
     * Checks if an option is defined
     *
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public function isSetOption($key)
    {
        if(is_string($key) === false) {
            throw new Exception('Invalid parameter type.');
        }

        if(is_array($this->_options) === true) {
            return isset($this->_options[$key]);
        }

        return false;
    }

    /**
     * Returns an option in the validator's options
     * Returns null if the option hasn't been set
     *
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public function getOption($key)
    {
        if(is_string($key) === false) {
            throw new Exception('Invalid parameter type.');
        }

        if(is_array($this->_options) === true) {
            if(isset($this->_options[$key]) === true) {
                return $this->_options[$key];
            }
        }

        return null;
    }

    /**
     * Sets an option in the validator
     *
     * @param string $key
     * @param mixed $value
     * @throws Exception
     */
    public function setOption($key, $value)
    {
        if(is_string($key) === false) {
            throw new Exception('Invalid parameter type.');
        }

        if(is_array($this->_options) === false) {
            $this->_options = array();
        }

        $this->_options[$key] = $value;
    }

    abstract public function validate(\UForm\Validation $validator);

}