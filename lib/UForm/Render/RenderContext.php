<?php


namespace UForm\Render;

use UForm\Forms\Element;
use UForm\Forms\FormContext;

/**
 *
 * used in template to wrap information about current rendering
 *
 * Class RenderContext
 * @package UForm\Render
 */
class RenderContext {

    /**
     * @var Element
     */
    public $element;
    /**
     * @var FormContext
     */
    protected $formContext;

    /**
     * @var AbstractRender
     */
    protected $render;

    function __construct(Element $element, FormContext $formContext, AbstractRender $render)
    {
        $this->element = $element;
        $this->formContext = $formContext;
        $this->render = $render;
    }

    public function renderElement(Element $element){
        return $this->render->renderElement($element, $this->formContext);
    }

    public function isValid(){
        return $this->formContext->elementIsValid($this->element->getName(true, true));
    }

}