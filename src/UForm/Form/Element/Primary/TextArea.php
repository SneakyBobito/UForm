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
 */
class TextArea extends Element\Primary implements Drawable
{
    public function __construct($name, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->addSemanticType("textarea");
    }


    public function render($value, $data)
    {

        $params = [
            "name" => $this->getName(true)
        ];

        if (isset($value[$this->getName()])) {
            $value = $value[$this->getName()];
        } else {
            $value = "";
        }

        $render = new Tag("textarea", $params, false);

        return $render->draw([], $value);
    }
}
