<?php

namespace UForm\Form\Element;

use UForm\Form\Element;
use UForm\Validation;
use UForm\Validation\Element\RangeValueValidationInterface;

/**
 * @semanticType radioGroup
 */
class RadioGroup extends Element implements RangeValueValidationInterface {
    
    protected $values;


    public function __construct($name, $values, $attributes = null, $validators = null, $filters = null) {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->values = $values;
        $this->addSemanticType("radioGroup");
    }

    public function validateOnSelfValues($message = null){
        $this->addValidator(new Validation\Validator\SelfValue(["message" => $message]));
    }
    
    public function _render( $attributes , $value , $data ){

        $renderHtml = "";
        
        $i=0;
        
        foreach ($this->values as $k=>$v){
            
            $id = $this->getName() . $i . rand(1000, 9999);
            $labelTag = new \UForm\Tag("label");
            $renderHtml .= $labelTag->draw(array(
                "for" => $id
            ), $v);
            
            $cbTag = new \UForm\Tag("input", array(
                "type" => "radio",
                "name" => $this->getName()
            ), true);
            
            
            $renderProp = array(
                "id" => $id,
                "value" => $k
            );
            
            if ( isset($value[$this->getName()]) && $value[$this->getName()] == $k ) {
                $renderProp["checked"] = "checked";
            }
            
            $renderHtml .= $cbTag->draw($renderProp);
            
            
        }
        
        return $renderHtml;
        
    }

    public function getValueRange()
    {
        return array_keys($this->values);
    }


}
