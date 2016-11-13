<?php

namespace UForm\Render;

use UForm\Form\Element;
use UForm\Form\Element\Container;
use UForm\Form\Form;
use UForm\Form\FormContext;
use UForm\OptionGroup;

abstract class AbstractHtmlRender
{

    use OptionGroup;

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
            $loader = new TwigLoaderFileSystem();
            $this->te = new \Twig_Environment($loader);
            $this->te->addExtension(new TwigExtension());

            $pathes = $this->getTemplatesPathes();
            foreach ($pathes as $namespace => $path) {
                $loader->addPath($path, $namespace); // allow to find a template by its namespace
                $loader->addPath($path); // allow to use twig multi-pathes feature
            }
        }
        return $this->te;
    }

    abstract public function getTemplatesPathes();

    /**
     * Get the name of the render that mainly serves to display accurate error messages for humans
     * @return string the name of the render
     */
    abstract public function getRenderName();


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
        $template = $this->resolveTemplate($semanticTypes);
        $renderContext = $this->generateRenderContext($element, $formContext, $semanticTypes);
        return $template->render(
            [
                'current' => $renderContext,
                'render'  => $this
            ]
        );
    }

    public function generateRenderContext(Element $element, FormContext $formContext, $semanticTypes)
    {
        return new RenderContext($element, $formContext, $this, $semanticTypes);
    }

    /**
     * Check if a template exists for the given semantic types
     * @param array $names a list of semantic types to find a template for
     * @return \Twig_TemplateInterface
     * @throws \Exception
     * @throws \Twig_Error_Loader
     */
    public function resolveTemplate(array &$names)
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
