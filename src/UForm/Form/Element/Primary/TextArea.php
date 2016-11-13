<?php
/**
 * Textarea
 */
namespace UForm\Form\Element\Primary;

use UForm\Form\Element;
use UForm\Form\Element\Drawable;
use UForm\Tag;

/**
 * Textarea element
 * @semanticType textarea
 * @renderOption label the label of the element
 * @renderOption placeholder a placeholder text to show when it's empty
 * @renderOption helper text that gives further information to the user (always visible)
 * @renderOption tooltip text that gives further information to the user (visible on mouse over or click)
 */
class TextArea extends Element\Primary implements Drawable
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->addSemanticType('textarea');
    }


    public function render($value, array $options = [])
    {

        $params = [
            'name' => $this->getName(true),
            'id'   => $this->getId()
        ];

        if (isset($value[$this->getName()])) {
            $value = $value[$this->getName()];
        } else {
            $value = '';
        }

        $render = new Tag('textarea', $params, false);

        return $render->draw([], $value);
    }
}
