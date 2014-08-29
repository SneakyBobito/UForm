<?php
/**
 * Textarea
 */
namespace UForm\Forms\Element;

use 
    UForm\Forms\Element,
    UForm\Tag
;

/**
 * Component TEXTAREA for forms
 *
 */
class TextArea extends Element{
      
    public function _render( $attributes , $value , $data , $prename = null ){

        $params = array(
            "name" => $this->getName($prename)
        );

        if(isset($value[$this->getName()])){
            $value = $value[$this->getName()];
        }else
            $value = "";
    
        
        $render = new Tag("textarea", $params , false);


        return $render->draw($attributes, $value);
    }
    
}
