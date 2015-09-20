<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary;

use UForm\Form\Element;
use UForm\Form\Exception;
use UForm\Tag;

/**
 * Class Select
 * @semanticType Select
 */
class Select extends Element
{
    /**
     * Options Values
     *
     * @var null|array|object
     * @access protected
     */
    protected $optionsValues;

    /**
     * \UForm\Form\Element constructor
     *
     * @param string $name
     * @param array|null $values
     * @param array|null $attributes
     * @throws Exception
     */
    public function __construct($name, array $values = null, $attributes = null)
    {


        $this->optionsValues = $values;
        parent::__construct($name, $attributes);
    }

    public function validateOnSelfValues($message = null)
    {
        $this->addValidator(new SelfValue(["message" => $message]));
    }

    public function getValueRange()
    {
        return $this->getOptions();
    }


    /**
     * Set the choice's options
     *
     * @param array|object $options
     * @return \UForm\Form\Element
     * @throws Exception
     */
    public function setOptions($options)
    {
        if (is_object($options) === false &&
            is_array($options) === false) {
            throw new Exception('Invalid parameter type.');
        }
        $this->optionsValues = $options;
        return $this;
    }

    /**
     * Returns the choices' options
     *
     * @return array|object|null
     */
    public function getOptions()
    {
        return $this->optionsValues;
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
        if (is_array($option) === false) {
            throw new Exception('Invalid parameter type.');
        }

        $this->optionsValues[] = $option;

        return $this;
    }


    public function __render($attributes, $value, $data)
    {

        $params = [
            "name" => $this->getName(true)
        ];

        if (isset($value[$this->getName()])) {
            $value = $value[$this->getName()];
        } else {
            $value = null;
        }

        $render = new Tag("select", $params, false);

        $options = "";

        foreach ($this->optionsValues as $k => $v) {
            $oTag = new Tag("option");
            $oattr = ["value"=>$k];
            if ($value == $k) {
                $oattr["selected"] = "selected";
            }
            $options .= $oTag->draw($oattr, $v);
        }

        return $render->draw($attributes, $options);
    }
}
