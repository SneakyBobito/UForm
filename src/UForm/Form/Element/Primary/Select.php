<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary;

use UForm\Form\Element;
use UForm\Form\Element\Primary\Select\OptGroup;
use UForm\Tag;

/**
 * Class Select
 * @semanticType Select
 */
class Select extends Element\Primary implements Element\Drawable
{
    /**
     * @var OptGroup
     */
    protected $rootGroup;

    /**
     * \UForm\Form\Element constructor
     *
     * @param string $name
     * @param array|null $values
     * @param array|null $attributes
     */
    public function __construct($name, array $values = null, $attributes = null)
    {
        parent::__construct($name, $attributes);

        $this->rootGroup = new OptGroup("");
        $this->rootGroup->setSelect($this);

        if (null !== $values) {
            $this->setOptionValues($values);
        }
    }


    /**
     * Set the choice's options
     *
     * @param array|object $options
     */
    public function setOptionValues(array $options)
    {
        $this->rootGroup->addOptions($options);
    }

    /**
     * Returns the choices' options
     *
     * @return array|object|null
     */
//    public function getOptionValues()
//    {
//        return $this->optionsValues;
//    }



    public function render($value, $data)
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

        foreach ($this->rootGroup->getOptions() as $v) {
            $options .= $v->render($value);
        }

        return $render->draw([], $options);
    }
}
