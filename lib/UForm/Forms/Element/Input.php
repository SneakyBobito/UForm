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
class Input extends Element {
    
    protected $type;

    public function __construct($type, $name, $attributes = null, $validators = null, $filters = null) {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->type = $type;
    }

    
    public function _render( $attributes , $value , $data , $prename = null ){

        $params = array(
            "type" => $this->type,
            "name" => $this->getName($prename)
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