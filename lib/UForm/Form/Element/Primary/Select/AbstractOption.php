<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Select;

use UForm\Form\Element\Primary\Select;

/**
 * Common class for option and optionGroup
 */
abstract class AbstractOption
{

    protected $label;

    /**
     * @var Select
     */
    protected $select;

    public function __construct($label = null)
    {
        $this->label = $label;
    }

    /**
     * get the label of the option
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the select the option belongs to
     * @param Select $select
     */
    public function setSelect(Select $select)
    {
        $this->select = $select;
    }

    /**
     * @return Select
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     * Render the option that can check if the given value matches its value.
     * Be aware that this render method differs from the Drawable::render method
     * @param $value
     * @return mixed
     */
    abstract public function render($value);
}
