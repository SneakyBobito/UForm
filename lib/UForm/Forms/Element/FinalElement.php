<?php
/**
 * Created by PhpStorm.
 * User: sghzal
 * Date: 9/15/15
 * Time: 4:51 PM
 */

namespace UForm\Forms\Element;


use UForm\Forms\Element;
use UForm\Render\RenderContext;

/**
 * A final element is the opposite of a container.
 * It cant contain other elements and therefor it can be rendered
 * Class FinalElement
 * @semanticType final
 */
abstract class FinalElement extends Element implements Drawable{
    public function __construct($name = null, $attributes = null, $validators = null, $filters = null)
    {
        parent::__construct($name, $attributes, $validators, $filters);
        $this->addSemanticType("final");
    }


    public function render(RenderContext $context){
        return $this->_render($context);
    }

    abstract protected function _render(RenderContext $context);

}