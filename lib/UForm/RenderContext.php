<?php

/**
 * @copyright (c) Rock A Gogo VPC
 */


namespace UForm;


use UForm\Forms\Element;
use UForm\Forms\ElementContainer;
use UForm\Forms\Exception;
use UForm\Forms\Form;

class RenderContext {

    /**
     * @var Form
     */
    protected $form;

    protected $data;
    protected $isValid;

    protected $elements = array();



    function __construct(Form $form)
    {
        $this->form = $form;

        $this->data = $form->getData();
        $this->isValid = $form->isValid();

        $initialElements = $form->getElements();

        if(!is_array($initialElements) || count($initialElements) <= 0 ){
            throw new Exception("Trying to generate a render helper with an empty form. The form must have at least 1 elements");
        }

        $this->_recursiveElementPreparation($initialElements,null);

    }

    /**
     * @param Element[] $elements
     * @param $prename
     */
    private function _recursiveElementPreparation($elements,$prename){

        foreach($elements as $el){

            $name = $el->getName($prename,true);

            if($name){

                $elC = new ElementContext($el,$prename);

                $this->elements[$name]["base"] = $elC;
                if($prename){
                    $this->elements[$prename]["children"][] = $elC;
                }
            }

            if($el instanceof ElementContainer){
                $this->_recursiveElementPreparation($el->getElements(), $name );
            }else if($el instanceof Element\Collection){

                $values = self::__getNavigator()->arrayGet($this->data,$this->data,$prename);

                $this->_recursiveElementPreparation($el->getElements($values) , $name);
            }

        }

    }


    public function render(ElementContext $elC,$attributes = null){

        $values = self::__getNavigator()->arrayGet($this->data,$this->data,$elC->getPrename());

        return $elC->getElement()->render($attributes , $values , $this->data , $elC->getPrename());

    }


    /**
     * @param $string
     * @return ElementContext
     */
    public function getElement($string){

        if(isset($this->elements[$string]) && isset($this->elements[$string]["base"]))
            return $this->elements[$string]["base"];

        return null;

    }


    /**
     * @param $string
     * @return ElementContext[]
     */
    public function getChildren($string){

        if(isset($this->elements[$string]) && isset($this->elements[$string]["children"]))
            return $this->elements[$string]["children"];

        return array();
    }



    // because 1 and only 1 navigator instance is required

    /**
     * @var Navigator
     */
    private static $__navigator;

    private static function __getNavigator(){

        if(!self::$__navigator)
            self::$__navigator = new Navigator();

        return self::$__navigator;
    }


} 