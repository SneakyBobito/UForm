<?php

namespace UForm\Render;

use UForm\Form\Element;

class TwigExtension extends \Twig_Extension
{

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "UForm_rendering";
    }


    public function getFunctions()
    {

        return [

            // RenderParentType
            // will render the parent semantic type for the current render context
            new \Twig_SimpleFunction('renderParentType', function ($context) {
                return $context["current"]->parentRender();
            }, [
                "needs_context" => true,
                "is_safe" => ["html"]
            ]),


            // RenderElement
            // shortcut to render the given element
            new \Twig_SimpleFunction('renderElement', function ($context, Element $element) {
                return $context["current"]->renderElement($element);
            }, [
                "needs_context" => true,
                "is_safe" => ["html"]
            ]),


            // defaultRenderFor
            // shortcut to render the current element with its default render method.
            // The element must implement Drawable interface
            new \Twig_SimpleFunction('defaultRenderFor', function ($context, Element $element, $options = []) {
                return $context["current"]->elementDefaultRender($element, $options);
            }, [
                "needs_context" => true,
                "is_safe" => ["html"]
            ]),

            // isValid
            // shortcut to check if an element is valid
            // Leave the first param empty to check current element
            new \Twig_SimpleFunction('isValid', function ($context, Element $element = null) {
                return $context["current"]->isValid($element);
            }, [
                "needs_context" => true
            ]),

            // childrenAreValid
            // shortcut to check if an element is valid
            // Leave the first param empty to check current element
            new \Twig_SimpleFunction('childrenAreValid', function ($context, Element $element = null) {
                return $context["current"]->childrenAreValid($element);
            }, [
                "needs_context" => true
            ])

        ];

    }
}
