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
class TextArea extends Element implements Drawable
{
      
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
