<?php

namespace UForm\Form\Element\Primary;

use UForm\Form\Element;
use UForm\Validation;

/**
 * @semanticType radioGroup
 */
class RadioGroup extends Element implements Element\Drawable
{
    
    protected $values;


    public function __construct($name, $values, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->values = $values;
        $this->addSemanticType("radioGroup");
    }
    
    public function render($value, $data)
    {
        $renderHtml = "";
        
        $i=0;
        
        foreach ($this->values as $k => $v) {
            $id = $this->getName() . $i . rand(1000, 9999);
            $labelTag = new \UForm\Tag("label");
            $renderHtml .= $labelTag->draw([
                "for" => $id
            ], $v);
            
            $cbTag = new \UForm\Tag("input", [
                "type" => "radio",
                "name" => $this->getName()
            ], true);
            
            
            $renderProp = [
                "id" => $id,
                "value" => $k
            ];
            
            if (isset($value[$this->getName()]) && $value[$this->getName()] == $k) {
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
