<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Select;

use UForm\Exception;

class OptionGroup
{

    /**
     * @var Option[]
     */
    protected $options = [];
    protected $label;

    public function __construct($label, array $options = null)
    {
        if (null !== $options) {
            $this->addOptions($options);
        }

        $this->label = $label;
    }

    public function addOption(Option $option)
    {
        $this->options[] = $option;
    }

    public function addOptions(array $options)
    {
        foreach ($options as $key => $option) {
            if (is_object($option)) {
                if (!$option instanceof Option) {
                    throw new Exception(
                        "An option is not valid for option factory. It should be an instance of Option, "
                        . "instead an instance of " . get_class($option) . " was given"
                    );
                }
            } else {
                if (!is_string($option)) {
                    throw new Exception(
                        "An option is not valid for option factory. It should be a string, "
                        . "instead " . gettype($option) . " was given"
                    );
                }

                if (is_int($key)) {
                    $option = new Option($option);
                } elseif (is_string($key)) {
                    $option = new Option($option, $key);
                }
            }

            $this->addOption($option);
        }
    }

    /**
     * @return Option[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }
}
