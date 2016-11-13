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

    /**
     * disables the option
     */
    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * enables the option
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * check if the option is enabled
     * @return bool tru if enabled
     */
    public function isEnabled()
    {
        return $this->enabled == true;
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
     * @inheritdoc
     */
    public function render($value)
    {

        $tag = new Tag('option');

        $params = [
            'value' => $this->getValue()
        ];


        if ($this->enabled) {
            if ((is_array($value) && in_array($this->getValue(), $value))
                || (!is_array($value) && $value == $this->getValue())
            ) {
                $params['selected'] = 'selected';
            }
        } else {
            if ($this->enabled === false) {
                $params['disabled'] = 'disabled';
            }
        }


        return $tag->draw($params, $this->getLabel());
    }
}
