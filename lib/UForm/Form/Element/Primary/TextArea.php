<?php
/**
 * Textarea
 */
namespace UForm\Form\Element;

use 
    UForm\Form\Element,
    UForm\Tag
;

/**
 * Component TEXTAREA for forms
 * @semanticType textarea
 */
class TextArea extends Element{
      
    public function _render( $attributes , $value , $data){

        $params = array(
            "name" => $this->getName(true)
        );

        if(isset($value[$this->getName()])){
            $value = $value[$this->getName()];
        }else
            $value = "";
    
        
        $render = new Tag("textarea", $params , false);


        return $render->draw($attributes, $value);
    }
    
}
