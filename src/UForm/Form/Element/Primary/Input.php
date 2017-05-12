<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary;

use UForm\Filter;
use UForm\Form\Element;
use UForm\Form\Element\Drawable;
use UForm\Form\Element\Primary;
use UForm\Tag;

/**
 * That a general class to simplify the code of element using the tag input
 * @semanticType input
 * @renderOption label the label of the element
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 */
class Input extends Primary implements Drawable
{

    private $inputType;
    use Element\RenderHandlerTrait;

    /**
     * @param string $type type of the input (text, password, radio,...)
     * @param string $name name of the input in the form
     */
    public function __construct($type, $name)
    {
        parent::__construct($name);
        $this->inputType = $type;
        $this->addSemanticType('input');
    }


    /**
     * @inheritdoc
     */
    public function render($localValue, array $options = [])
    {

        $options = $this->processRenderOptionHandlers($localValue, $options);

        $params = [
            'type' => $this->inputType,
            'name' => $this->getName(true),
            'id'   => $this->getId()
        ];

        foreach ($this->getAttributes() as $attrName => $attrValue) {
            $params[$attrName] = $attrValue;
        }

        if (isset($options['attributes']) && is_array($options['attributes'])) {
            foreach ($options['attributes'] as $attrName => $attrValue) {
                $params[$attrName] = $attrValue;
            }
        }


        if (isset($options['class'])) {
            $params['class'] = $options['class'];
        }

        if (is_array($localValue) && isset($localValue[$this->getName()])) {
            $params['value'] = (string)$localValue[$this->getName()];
        }

        $render = new Tag('input', $this->overridesParamsBeforeRender($params, $localValue), true);

        return $render->draw([], null);
    }

    /**
     * allows subclasses to redefine some params before the rendering
     * (e.g checkbox will use 'checked' instead of 'value')
     * @param $params
     * @param $value
     * @return mixed
     */
    protected function overridesParamsBeforeRender($params, $value)
    {
        return $params;
    }
}
