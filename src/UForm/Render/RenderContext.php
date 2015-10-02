<?php


namespace UForm\Render;

use UForm\Form\Element;
use UForm\Form\FormContext;
use UForm\Render\AbstractHtmlRender as AbstractRender;

/**
 *
 * used in template to wrap information about current rendering
 *
 * Class RenderContext
 * @package UForm\Render
 */
class RenderContext
{

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

    protected $parentTypes=[];

    public function __construct(Element $element, FormContext $formContext, AbstractRender $render, $parentTypes)
    {
        $this->element = $element;
        $this->formContext = $formContext;
        $this->render = $render;
        $this->parentTypes = $parentTypes;
    }

    public function renderElement(Element $element)
    {
        return $this->render->renderElement($element, $this->formContext);
    }

    /**
     * Render the next parent semantic type available
     * @return string
     */
    public function parentRender()
    {
        return $this->render->renderElementAs($this->element, $this->formContext, $this->parentTypes);
    }

    public function isValid()
    {
        return $this->formContext->elementIsValid($this->element);
    }

    public function elementDefaultRender(Element $element, $options = [])
    {

        if ($element instanceof Element\Drawable) {
            return $element->render($this->getLocalValue(), $options);
        } else {
            throw new \UForm\Exception(
                "Trying to render an invalid element. Element not implementing Drawable cant be rendered"
            );
        }

    }

    public function getLocalValue()
    {
        return $this->formContext->getData()->getDataCopy();
    }
}
