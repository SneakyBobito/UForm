<?php

namespace UForm\Render;

use UForm\Form\Element;
use UForm\Form\Element\Container;
use UForm\Form\Form;
use UForm\Form\FormContext;

abstract class AbstractRender
{

    /**
     * @var \Twig_Environment
     */
    protected $te = null;


    /**
     * @return \Twig_Environment
     */
    public function getTwigEnvironment()
    {
        if (null == $this->te) {
            $loader = new TwigLoaderFileSystem($this->getTemplatesPath());
            $this->te = new \Twig_Environment($loader);
            $this->te->addExtension(new TwigExtension());
        }
        return $this->te;
    }

    abstract public function getTemplatesPath();


    public function render(FormContext $formContext)
    {
        return $this->renderElement($formContext->getForm(), $formContext);
    }

    /**
     * @param Element $element
     * @param FormContext $formContext
     * @return string
     * @throws \Exception
     * @throws \Twig_Error_Loader
     */
    public function renderElement(Element $element, FormContext $formContext)
    {
        $semanticTypes = $element->getSemanticTypes();
        return $this->renderElementAs($element, $formContext, $semanticTypes);
    }

    /**
     * Allows to render an element as any other element.
     *
     * Internally it is always used with safety.
     * If you use it manually make sure to check the context of the rendering or
     * you may encounter unexisting method usage
     *
     * @param Element $element
     * @param FormContext $formContext
     * @param $semanticTypes
     * @return string
     * @throws \Exception
     * @throws \Twig_Error_Loader
     */
    public function renderElementAs(Element $element, FormContext $formContext, $semanticTypes)
    {
        $template = $this->__resolveTemplate($semanticTypes);
        $renderContext = new RenderContext($element, $formContext, $this, $semanticTypes);
        return $template->render(["current" => $renderContext]);
    }

    private function __resolveTemplate(array &$names)
    {


        $failedNames = [];

        while (count($names) > 0) {
            $name = array_shift($names);
            $failedNames[] = $name;

            try {
                return $this->getTwigEnvironment()->loadTemplate($name);
            } catch (\Twig_Error_Loader $e) {
            }
        }


        if (1 === count($failedNames)) {
            // MESSAGE FOR 1 FAIL
            throw $e;
        } else {
            // MESSAGE FOR MANY FAILS
            throw new \Twig_Error_Loader(
                sprintf('Unable to find one of the following templates: "%s".', implode('", "', $failedNames))
            );
        }


    }
}
