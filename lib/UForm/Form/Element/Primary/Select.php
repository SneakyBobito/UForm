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
        parent::__construct($name, $attributes);
        if (null !== $values) {
            $this->setOptionValues($values);
        }
    }




    /**
     * Set the choice's options
     *
     * @param array|object $options
     * @return \UForm\Form\Element
     */
    public function setOptionValues(array $options)
    {
        $this->optionsValues = $options;
        return $this;
    }

    /**
     * Returns the choices' options
     *
     * @return array|object|null
     */
    public function getOptionValues()
    {
        return $this->optionsValues;
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
