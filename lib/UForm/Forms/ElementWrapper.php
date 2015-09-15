<?php

namespace UForm\Forms;

/**
 * ElementWrapper allows to wrap an element. The main goal is to 
 * - add your own parameters for rendering latter
 * - redefine the render method
 * @author sghzal
 */
class ElementWrapper extends Element {
    
    /**
     *
     * @var Element
     */
    protected $_wrapped;
    
    function __construct(Element $element) {
        $this->_wrapped = $element;
    }
    
    public function _render($attributes, $value, $data) {
        return $this->_wrapped->_render($attributes, $value, $data);
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