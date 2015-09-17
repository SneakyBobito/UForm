<?php
/**
 * @license see LICENSE
 */

namespace UForm;


trait OptionGroup {

    protected $_optionGroup = [];

    /**
     * Sets an option
     *
     * @param string $option name of the option
     * @param mixed $value value of the option
     * @return $this
     * @throws Exception
     */
    public function setOption($option, $value)
    {
        if (is_string($option) === false) {
            throw new Exception('Invalid parameter type.');
        }
        $this->_optionGroup[$option] = $value;
        return $this;
    }

    /**
     * Returns the value of an option if present
     *
     * You can specify a default value to return if the option does not exist
     *
     * @param string $option name of the option
     * @param mixed $defaultValue default value to return if option does not exist
     * @return mixed value of the option or the default value
     * @throws Exception
     */
    public function getOption($option, $defaultValue = null)
    {
        if (isset($this->_optionGroup[$option])) {
            return $this->_optionGroup[$option];
        }
        return $defaultValue;
    }

    /**
     * Set value of many options
     *
     * @param array $options list of the options ["optionName" => "value"]
     * @return $this
     * @throws Exception
     */
    public function addOptions($options)
    {
        if (is_array($options) === false) {
            throw new Exception("Parameter 'options' must be an array");
        }
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
        return $this;
    }

    /**
     * Resets the options and set the given options instead
     *
     * @param array|null $options array of the new options to set. Can be null or an empty array to reset remove all options
     * @return $this
     * @throws Exception
     */
    public function setOptions($options){
        $this->_optionGroup = [];
        return $this->addOptions($options);
    }

    /**
     * Returns the options for the element
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->_optionGroup;
    }

}