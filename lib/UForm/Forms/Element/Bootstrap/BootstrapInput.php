<?php

namespace UForm\Forms\Element\Bootstrap;

use UForm\Forms\Element,
    UForm\Tag
;
use UForm\Forms\Group\Tab;

/**
 * Input
 *
 * @author sghzal
 */
class BootstrapInput extends Element\Input {

    public function _render( $attributes , $value , $data , $prename = null ){

        $inputHtml = parent::_render($attributes , $value , $data , $prename = null);

        $leftAddon = $this->getUserOption("leftAddon");
        $rightAddon = $this->getUserOption("rightAddon");
        if($leftAddon || $rightAddon){

            $renderAddon = new Tag("span",[
                "class"=>"input-group-addon"
            ]);
            if($leftAddon) {
                $inputHtml = $renderAddon->draw(null, $leftAddon) . $inputHtml;
            }
            if($rightAddon) {
                $inputHtml .= $renderAddon->draw(null, $rightAddon);
            }

            $inputGroup = new Tag("div",[
                "class" => "input-group"
            ]);

            return $inputGroup->draw(null, $inputHtml);

        }else{
            return $inputHtml;
        }


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