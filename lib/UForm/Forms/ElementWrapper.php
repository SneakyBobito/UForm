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
     * @var ElementInterface
     */
    protected $_wrapped;
    
    function __construct(ElementInterface $element) {
        $this->_wrapped = $element;
    }
    
    public function render($attributes, $value, $data, $prename = null) {
        return $this->_wrapped->render($attributes, $value, $data,$prename);
    }
    
    public function setForm($form) {
        parent::setForm($form);
        $this->_wrapped->setForm($form);
    }
    
    public function getName($prename = null, $dottedNotation = false) {
        return $this->_wrapped->getName($prename, $dottedNotation);
    }
    
    public function prepareValidation($localValues, \UForm\Validation\ChainedValidation $cV, $prename = null) {
        return $this->_wrapped->prepareValidation($localValues, $cV, $prename);
    }

    
}