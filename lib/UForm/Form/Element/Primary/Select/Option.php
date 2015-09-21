<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Select;

/**
 * Option is aimed to to help select to render
 */
class Option
{

    protected $value;
    protected $label;

    /**
     * @param string $value the value of the option (used for value="$value")
     * @param string $label label of the option (used for <option>$label</option>
     */
    public function __construct($value, $label = null)
    {
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * get the value of the option
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * get the label of the option
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
}
