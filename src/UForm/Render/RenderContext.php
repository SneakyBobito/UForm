<?php


namespace UForm\Render;

use UForm\Form\Element;
use UForm\Form\FormContext;
use UForm\Navigator;
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

    /**
     * Check if the current element is valid
     * @return bool
     */
    public function isValid(Element $element = null)
    {
        if (null === $element) {
            $element = $this->element;
        }
        return $this->formContext->elementIsValid($element);
    }

    /**
     * Process to the default render of the given element. The element must implement Drawable
     * @param Element $element
     * @param array $options
     * @return mixed
     * @throws \UForm\Exception
     */
    public function elementDefaultRender(Element $element, $options = [])
    {

        if ($element instanceof Element\Drawable) {
            $navigator = new Navigator();
            $value = $navigator->arrayGet(
                $this->formContext->getData()->getDataCopy(),
                $element->getName(true, true),
                1
            );

            return $element->render($value, $options);
        } else {
            throw new \UForm\Exception(
                'Trying to render an invalid element. Element not implementing Drawable cant be rendered'
            );
        }
    }

    /**
     * Get the value of the current element
     * @return array
     */
    public function getLocalValue()
    {
        return $this->formContext->getData()->getDataCopy();
    }

    /**
     * Get the children of the current element
     * @return \UForm\Form\Element[]
     */
    public function getChildren()
    {
        if ($this->element instanceof Element\Container) {
            return $this->element->getElements($this->getLocalValue());
        }
        return [];
    }

    /**
     * Get the children of the current element
     * @return \UForm\Form\Element[]
     */
    public function getMessages()
    {
        return $this
            ->formContext
            ->getChainedValidation()
            ->getValidation($this->element->getInternalName(true), true)
            ->getMessages();
    }

    /**
     * Checks if children of an element are valid
     * @param Element|null $element leave it null to check the current element or give an element instance to check it
     */
    public function childrenAreValid(Element $element = null)
    {
        if (null === $element) {
            $element = $this->element;
        }
        return $this->formContext->childrenAreValid($element);
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        switch ($name) {
            case 'children':
                return $this->getChildren();
            case 'messages':
                return $this->getMessages();
            default:
                return null;
        }
    }
}
