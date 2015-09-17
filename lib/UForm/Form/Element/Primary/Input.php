<?php

namespace UForm\Form\Element\Primary;

use UForm\Form\Element;
use UForm\Tag;

/**
 *
 * @semanticType input
 */
class Input extends Element\Primary  {
    
    private $inputType;

    public function __construct($type, $name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->inputType = $type;
        $this->addSemanticType("input");
        $this->addSemanticType("input:$type");
    }

    
    public function _render($localValue, $data){


        $params = array(
            "type" => $this->inputType,
            "name" => $this->getName(true)
        );

        if(is_array($localValue) && isset($localValue[$this->getName()])){
            $params["value"] = $localValue[$this->getName()];
        }
       
        $render = new Tag("input", $this->overidesParamsBeforeRender($params , [] , $localValue , $data) , true);

        return $render->draw([], null);
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