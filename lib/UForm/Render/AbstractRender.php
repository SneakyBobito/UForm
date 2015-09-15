<?php

namespace UForm\Render;


use UForm\Forms\Element;
use UForm\Forms\ElementContainer;
use UForm\Forms\Form;
use UForm\Forms\FormContext;

abstract class AbstractRender {

    /**
     * @var \Twig_Environment
     */
    protected $_te = null;


    /**
     * @return \Twig_Environment
     */
    public function getTwigEnvironment(){
        if(null == $this->_te){
            $loader = new TwigLoaderFileSystem($this->getTemplatesPath());
            $this->_te = new \Twig_Environment($loader);
            $this->_te->addExtension(new TwigExtension());
        }
        return $this->_te;
    }

    abstract public function getTemplatesPath();


    public function render(FormContext $formContext){
        return $this->renderElement($formContext->getForm(), $formContext);
    }

    /**
     * @param Element $element
     * @param FormContext $formContext
     * @return string
     * @throws \Exception
     * @throws \Twig_Error_Loader
     */
    public function renderElement(Element $element, FormContext $formContext){
        $semanticTypes = $element->getSemanticTypes();
        return $this->renderElementAs($element, $formContext, $semanticTypes);
    }

    /**
     * Allows to render an element as any other element.
     *
     * Internally it always used with safety. If you use it manually make sure to check the context of the rendering OR
     * you may encounter unexisting method usage
     *
     * @param Element $element
     * @param FormContext $formContext
     * @param $semanticTypes
     * @return string
     * @throws \Exception
     * @throws \Twig_Error_Loader
     */
    public function renderElementAs(Element $element, FormContext $formContext, $semanticTypes){
        $template = $this->_resolveTemplate($semanticTypes);
        $renderContext = new RenderContext($element, $formContext, $this, $semanticTypes);
        return $template->render(["current" => $renderContext]);
    }

    private function _resolveTemplate(&$names){

        if (!is_array($names)) {
            $names = array($names);
        }

        $failedNames = [];

        while(count($names) > 0) {
            $name = array_shift($names);
            $failedNames[] = $name;

            try {
                return $this->getTwigEnvironment()->loadTemplate($name);
            } catch (\Twig_Error_Loader $e) {
            }
        }

        if (1 === count($failedNames)) {
            throw $e;
        }

        throw new \Twig_Error_Loader(sprintf('Unable to find one of the following templates: "%s".', implode('", "', $failedNames)));

    }

}