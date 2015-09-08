<?php

namespace UForm\Forms\Element;

/**
 * Phalcon\Forms\Element\Check
 *
 * Component INPUT[type=check] for forms
 * 
 * @see https://github.com/phalcon/cphalcon/blob/1.2.6/ext/forms/element/check.c
 */
class RadioGroup extends \UForm\Forms\Element{
    
    protected $values;


    public function __construct($name, $values, $attributes = null, $validators = null, $filters = null) {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->values = $values;
        $this->addSemanticType("radioGroup");
    }

    
    public function _render( $attributes , $value , $data , $prename = null ){

        $renderHtml = "";
        
        $i=0;
        
        foreach ($this->values as $k=>$v){
            
            $id = $this->getName() . $i . rand(1000, 9999);
            $labelTag = new \UForm\Tag("label");
            $renderHtml .= $labelTag->draw(array(
                "for" => $id
            ), $k);
            
            $cbTag = new \UForm\Tag("input", array(
                "type" => "radio",
                "name" => $this->getName()
            ), true);
            
            
            $renderProp = array(
                "id" => $id,
                "value" => $v
            );
            
            if ( isset($value[$this->name]) && $value[$this->name] == $v ) {
                $renderProp["checked"] = "checked";
            }
            
            $renderHtml .= $cbTag->draw();
            
            
        }
        
        return $renderHtml;
        
    }
    



}