<?php

namespace UForm\Form\Element\Container;

use UForm\DataContext;
use UForm\Form\Element\Container;
use UForm\Form\Element\Drawable;
use UForm\Form\FormContext;
use UForm\Validation\ChainedValidation;

/**
 * Group that can contains many elements
 *
 * @author sghzal
 * @semanticType group
 */
class Group extends Container implements Drawable{
    
    /**
     * @var \UForm\Form\Element[]
     */
    protected $elements = array();

    public function __construct($name = null, $elements = null) {
        parent::__construct($name);
        if(is_array($elements)){
            foreach ($elements as $el){
                $this->addElement($el);
            }
        }else if(is_object($elements)){
            $this->addElement($elements);
        }
        $this->addSemanticType("group");
    }
    
    public function addElement(\UForm\Form\Element $element){
        $iname = "i" . count($this->elements);
        $this->elements[$iname] = $element;
        $element->setParent($this);
        $element->setInternalName($iname);
    }
    
    public function getName($prenamed = null, $dottedNotation = false) {
        if (null === $this->_name) {
            return $this->_prename;
        }

        return parent::getName($prenamed, $dottedNotation);
    }

    public function render($values, $data) {
        $render = "";

        foreach($this->elements as $element){
            $hasName = null !== $this->_name ;

            $valuesLocal =  null;
            if($hasName){
                $valuesLocal = $values[$this->getName()];
            }

            $attributesLocal = null;

            $render .= $element->render($valuesLocal , $data);
        }
        
        return $render;
    }

    /**
     * @inheritdoc
     */
    public function getElement($name){
        if (!is_array($name)) {
            $namesP = explode(".", $name);
        }else{
            $namesP = $name;
        }
        
        $finalElm = $this->getDirectElement($namesP[0]);
        
        if( $finalElm && count($namesP)>1){
            array_shift($namesP);
            return $finalElm->getElement(($namesP));
        }
        return $finalElm;
    }


    public function getDirectElement($name){
        foreach($this->elements as $elm){
            if( $name == $elm->getName()){
                return $elm;
            }else if( !$elm->getName() && $elm instanceof ElementContainer ){
                /* @var $elm \UForm\Form\ElementContainer */
                $element = $elm->getDirectElement($name);
                if($element) {
                    return $element;
                }
            }
        }
        return null;
    }


    /**
     * @param null $values
     * @return \UForm\Form\Element[]
     */
    public function getElements($values = null){
        return $this->elements;
    }


    /**
     * @inheritdoc
     */
    public function prepareValidation(DataContext $localValues, FormContext $formContext){
        parent::prepareValidation($localValues, $formContext);
        $name = $this->getName();
        foreach ($this->getElements() as $k=>$v){
            if($name){
                $values = $localValues->getDirectValue($name);
            }else{
                $values = $localValues->getDataCopy();
            }
            $v->prepareValidation(new DataContext($values), $formContext);
        }
    }
    
    public function childrenAreValid(ChainedValidation $cV) {
        
        foreach($this->getElements() as $el){
            
            $v = $cV->getValidation($el->getInternalName(true),true);
     
            if(!$v->isValid()) {
                return false;
            }
            
            if(!$el->childrenAreValid($cV)) {
                return false;
            }
        }
        
        return true;
    }

}
