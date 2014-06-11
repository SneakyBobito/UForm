<?php

namespace UForm\Forms\Element;

use UForm\Forms\Element,
    UForm\Forms\ElementInterface,
    UForm\Tag
;

/**
 * Input
 *
 * @author sghzal
 */
class Input extends Element implements ElementInterface {
    
    protected $type;

    public function __construct($type, $name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->type = $type;
    }

    
    public function render( $attributes , $value , $data , $prename = null ){

        $params = array(
            "type" => $this->type,
            "name" => $this->getName($prename)
        );

        if(isset($value[$this->getName()])){
            $params["value"] = $value[$this->getName()];
        }

        $params = $this->overidesParamsBeforeRender($params , $attributes , $value , $data , $prename);
        
        $render = new Tag("input", $params , true);


        return $render->draw($attributes, null);
    }
    
    protected function overidesParamsBeforeRender($params , $attributes , $value , $data , $prename = null){
        return $params;
    }
    
}