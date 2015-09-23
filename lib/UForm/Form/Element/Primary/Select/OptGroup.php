<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Select;

use UForm\Exception;
use UForm\Form\Element\Primary\Select;
use UForm\Tag;

class OptGroup extends AbstractOption
{

    /**
     * @var Option[]
     */
    protected $options = [];

    public function __construct($label, array $options = null)
    {
        if (null !== $options) {
            $this->addOptions($options);
        }
        parent::__construct($label);
    }

    public function addOption(AbstractOption $option)
    {
        $this->options[] = $option;

        if ($this->select) {
            $option->setSelect($this->getSelect());
        }
    }

    public function setSelect(Select $select)
    {
        $this->select = $select;
        foreach ($this->options as $option) {
            $option->setSelect($select);
        }
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
            } elseif (is_array($option)) {
                if (!is_string($key)) {
                    throw new Exception(
                        "An option is not valid for option factory.When the value is an array "
                        . "then the key should be a string that represents the name of the optgroup"
                    );
                } else {
                    $option = new OptGroup($key, $option);
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
     * @return AbstractOption[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function render($value)
    {
        $tag = new Tag("optgroup");
        $params = [
            "label" => $this->getLabel()
        ];
        $optionsRender = '';
        foreach ($this->getOptions() as $option) {
            $optionsRender .= $option->render($value);
        }
        return $tag->draw($params, $optionsRender);
    }
}
