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

    public function _render( $attributes , $value , $data ){

        $inputHtml = parent::_render($attributes , $value , $data);

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
    
}