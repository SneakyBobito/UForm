<?php

namespace UForm\Forms\Element;

use \UForm\Forms\Element,
        \UForm\Forms\Exception,
        UForm\Tag;

class Select extends Element
{
        /**
         * Options Values
         * 
         * @var null|array|object
         * @access protected
        */
        protected $_optionsValues;

        /**
         * \UForm\Forms\Element constructor
         *
         * @param string $name
         * @param object|array|null $options
         * @param array|null $attributes
         * @throws Exception
         */
        public function __construct($name, $options = null, $attributes = null)
        {
            if(is_object($options) === false &&
                is_array($options) === false &&
                is_null($options) === false) {
                throw new Exception('Invalid parameter type.');
            }

            $this->_optionsValues = $options;
            parent::__construct($name, $attributes);
        }
        
        public function validateOnSelfValues($message = null){
            
            $values = $this->getOptions();
            if(!$message)
                $message = "Choice not valid";
            
            $this->addValidator(new \UForm\Validation\DirectValidator(function(\UForm\Validation $v) use ($values,$message){
                if(!isset($values[$v->getValue()])){
                    $v->appendMessage($message);
                    return false;
                }
            }));
        }

        /**
         * Set the choice's options
         *
         * @param array|object $options
         * @return \UForm\Forms\Element
         * @throws Exception
         */
        public function setOptions($options)
        {
            if(is_object($options) === false &&
                is_array($options) === false) {
                throw new Exception('Invalid parameter type.');
            }
            $this->_optionsValues = $options;
            return $this;
        }

        /**
         * Returns the choices' options
         *
         * @return array|object|null
         */
        public function getOptions()
        {
            return $this->_optionsValues;
        }

        /**
         * Adds an option to the current options
         *
         * @param array $option
         * @return $this
         * @throws Exception
         */
        public function addOption($option)
        {
            if(is_array($option) === false) {
                throw new Exception('Invalid parameter type.');
            }

            $this->_optionsValues[] = $option;

            return $this;
        }

         
        public function _render( $attributes , $value , $data , $prename = null ){

            $params = array(
                "name" => $this->getName($prename)
            );

            if(isset($value[$this->getName()])){
                $value = $value[$this->getName()];
            }  else {
                $value = null;
            }

            $render = new Tag("select", $params , false);

            $options = "";
            
            foreach ($this->_optionsValues as $k=>$v){
                $oTag = new Tag("option");
                $oattr = array("value"=>$k);
                if($value == $k)
                    $oattr["selected"] = "selected";
                $options .= $oTag->draw($oattr, $v);
            }

            return $render->draw($attributes, $options);
        }
}
