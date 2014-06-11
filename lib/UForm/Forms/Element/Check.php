<?php

namespace UForm\Forms\Element;

class Check extends Input{
    
    protected $value;


    public function __construct($name,$value = null, $attributes = null, $validators = null, $filters = null) {
        parent::__construct("checkbox", $name, $attributes, $validators, $filters);
        $this->value = $value; 
    }
    
    protected function overidesParamsBeforeRender($params, $attributes, $value, $data, $prename = null) {
        
        if(isset($value[$this->getName()]) && $value[$this->getName()] == $this->value  ){
            $params["checked"] = "checked";
        }
        
        if($this->value)
            $params["value"] = $this->value;
        else
            unset($params["value"]);
        
        return $params;
        
    }



}