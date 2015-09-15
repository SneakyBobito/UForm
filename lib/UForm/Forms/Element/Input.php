<?php

namespace UForm\Forms\Element;

use UForm\Forms\Element,
    UForm\Tag
;

/**
 * Input
 *
 * @author sghzal
 * @semanticType input
 */
class Input extends Element  {
    
    private $inputType;

    public function __construct($type, $name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->inputType = $type;
        $this->addSemanticType("input");
        $this->addSemanticType("input:$type");
    }

    
    public function _render( $attributes , $value , $data , $prename = null ){
        
        $params = array(
            "type" => $this->inputType,
            "name" => $this->getName(true)
        );

        if(is_array($value) && isset($value[$this->getName()])){
            $params["value"] = $value[$this->getName()];
        }
       
        $render = new Tag("input", $this->overidesParamsBeforeRender($params , $attributes , $value , $data , $prename) , true);

        return $render->draw($attributes, null);
    }

    /**
     * allows subclasses to redefine some params before the rendering (e.g checkbox will use 'checked' instead of 'value'
     * @param $params
     * @param $attributes
     * @param $value
     * @param $data
     * @param null $prename
     * @return mixed
     */
    protected function overidesParamsBeforeRender($params , $attributes , $value , $data , $prename = null){
        return $params;
    }

}