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
 * @semanticType select
 * @renderOption label the label of the element
 * @renderOption placeholder a placeholder text to show when it's empty
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 * @renderOption leftAddon an addon to add to the left of the field
 * @renderOption rightAddon an addon to add to the right of the field
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
    public function __construct($name, array $values = null)
    {
        parent::__construct($name);

        $this->rootGroup = new OptGroup('');
        $this->rootGroup->setSelect($this);

        if (null !== $values) {
            $this->setOptionValues($values);
        }

        $this->addSemanticType('select');
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



    public function render($value, array $options = [])
    {
        $params = [
            'id' => $this->getId(),
            'name' => $this->getName(true)
        ];

        if (isset($options['class'])) {
            $params['class'] = $options['class'];
        }

        if (isset($value[$this->getName()])) {
            $value = $value[$this->getName()];
        } else {
            $value = null;
        }

        $render = new Tag('select', $params, false);

        $selectOptions = '';

        foreach ($this->rootGroup->getOptions() as $v) {
            $selectOptions .= $v->render($value);
        }

        return $render->draw([], $selectOptions);
    }
}
