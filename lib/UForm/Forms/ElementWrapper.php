<?php

namespace UForm\Forms;

use UForm\Forms\Element\Drawable;
use UForm\Render\RenderContext;

/**
 * ElementWrapper allows to wrap an element. The main goal is to 
 * - add your own parameters for rendering latter
 * - redefine the render method
 * @author sghzal
 */
class ElementWrapper extends Element implements Drawable {
    
    /**
     *
     * @var Element
     */
    protected $_wrapped;
    
    function __construct(Element $element) {
        $this->_wrapped = $element;
    }
    
    public function render(RenderContext $renderContext) {
        return $this->_wrapped->_render($renderContext);
    }
    
    public function setParent(ElementContainer $p,$iname = null){
        parent::setParent($p,$iname);
        $this->_wrapped->setParent($p,$iname);
    }
    
    public function getName($prename = null, $dottedNotation = false) {
        return $this->_wrapped->getName($prename, $dottedNotation);
    }
    
    public function getInternalName($prenamed = false) {
        parent::getInternalName($prenamed);
    }
    
    public function prepareValidation($localValues, \UForm\Validation\ChainedValidation $cV, $prename = null) {
        return $this->_wrapped->prepareValidation($localValues, $cV, $prename);
    }

    
    
}