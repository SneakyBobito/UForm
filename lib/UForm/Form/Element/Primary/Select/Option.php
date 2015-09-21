<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Select;

use UForm\Tag;

/**
 * Option is aimed to to help select to render
 */
class Option extends AbstractOption
{

    protected $value;
    protected $enabled = true;

    /**
     * @param string $value the value of the option (used for value="$value")
     * @param string $label label of the option (used for <option>$label</option>
     */
    public function __construct($value, $label = null)
    {
        $this->value = $value;
        parent::__construct($label);
    }

    public function disable()
    {
        $this->enabled = false;
    }

    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * get the value of the option
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    public function render($local, $data)
    {

        $tag = new Tag("option");

        $params = [
            "value" => $this->getValue()
        ];

        if ($this->select) {
            $selectName = $this->getSelect()->getName();
            if (isset($local[$selectName]) && $local[$selectName] == $this->getValue()) {
                $params["selected"] = "selected";
            }
        }
        if ($this->enabled === false) {
            $params["disabled"] = "disabled";
        }

        return $tag->draw($params, $this->getLabel());

    }
}
