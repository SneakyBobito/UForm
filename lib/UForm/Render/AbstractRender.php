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
        $template = $this->getTwigEnvironment()->resolveTemplate($semanticTypes);
        $renderContext = new RenderContext($element, $formContext, $this);
        return $template->render(["current" => $renderContext]);
    }

}