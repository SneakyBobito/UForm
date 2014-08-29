<?php

/**
 * @copyright (c) Rock A Gogo VPC
 */


namespace UForm;


use UForm\Forms\Element;
use UForm\Forms\ElementContainer;
use UForm\Forms\ElementInterface;
use UForm\Forms\Exception;
use UForm\Forms\Form;
use UForm\Validation\ChainedValidation;

class RenderContext {

    /**
     * @var Form
     */
    protected $form;

    protected $data;
    protected $isValid;
    
    // all named elements 
    protected $elements = array();
    // all unamed elements
    protected $unamedElements = array();
    // all base element
    protected $baseElements = array();


    /**
     * @var ChainedValidation
     */
    protected $validation;


    function __construct(Form $form)
    {
        $this->form = $form;

        $this->data = $form->getData();
        $this->isValid = $form->isValid();

        $initialElements = $form->getElements();

        $this->validation = $form->getValidation();

        if(!is_array($initialElements) || count($initialElements) <= 0 ){
            throw new Exception("Trying to generate a render helper with an empty form. The form must have at least 1 elements");
        }

        $this->_recursiveElementPreparation($initialElements,null,null,true);

    }

    public function getBaseElements() {
        return $this->baseElements;
    }
    
    public function childrenAreValid($elm){
        
        $elC = $this->__parseElement($elm);

        if(!$elC){

            if(is_string($elm))
                throw new Exception('Element with ID='.$elm.' is not part of the form');
            else
                throw new Exception('Invalid param for checking element validation');
        }
        
        $valid = true;
        
        if( ! $this->elementIsValid($elC) ){
            return false;
        }
            
        
        if( $elC->getElement() instanceof ElementContainer ){
            foreach ($elC->getChildren() as $cElC){
                $cValid = $this->childrenAreValid($cElC);
                if(!$cValid){
                    $valid = false;
                    break;
                }
            }
        }
        
        return $valid;
        
    }

        
    /**
     * @param Element[] $elements
     * @param $prename
     */
    private function _recursiveElementPreparation($elements,$prename,$parent=null,$base=false){

        foreach($elements as $el){

            $elC = new ElementContext($el,$prename);
            
            if($parent){
                $elC->setParent($parent);
                $parent->addChild($elC);
            }
            
            if($el->getName() !== null){
                $name = $el->getName($prename,true);
                $this->elements[$name] = $elC;
            }else{
                $this->unamedElements[] = $elC;
            }
            
            if($base){
                $this->baseElements[] = $elC;
            }

            if($el instanceof ElementContainer){
                $name = $el->getName($prename,true);
                $this->_recursiveElementPreparation($el->getElements(), $name , $elC);
            }else if($el instanceof Element\Collection){
                $name = $el->getName($prename,true);
                $values = self::__getNavigator()->arrayGet($this->data,$this->data,$prename);
                $this->_recursiveElementPreparation($el->getElements($values) , $name , $elC);
            }

        }

    }

    public function elementIsValid($elm){
        if(!$this->validation)
            return true;

        $elC = $this->__parseElement($elm);

        if(!$elC){

            if(is_string($elm))
                throw new Exception('Element with ID='.$elm.' is not part of the form');
            else
                throw new Exception('Invalid param for checking element validation');
        }

        $validation = $this->validation->getValidation($elC->getFullName(true));

        return $validation->isValid();
    }

    public function elementMessages($elm){

        if(!$this->validation)
            return array();

        $elC = $this->__parseElement($elm);

        if(!$elC){

            if(is_string($elm))
                throw new Exception('Element with ID='.$elm.' is not part of the form');
            else
                throw new Exception('Invalid param for checking element validation');
        }



        $validation = $this->validation->getValidation($elC->getFullName(true));

        return $validation->getMessages();

    }

    /**
     * @param $elC
     * @return ElementContext
     */
    private function __parseElement($elC){

        if($elC instanceof ElementContext)
            ;
        else if($elC instanceof ElementInterface){
            do{
                foreach($this->elements as $el){
                    if($elC == $el->getElement()){
                        $elC = $el;
                        break 2;
                    }
                }
                foreach($this->unamedElements as $el){
                    if($elC == $el->getElement()){
                        $elC = $el;
                        break 2;
                    }
                }
            }while(false);
                
        }else if(is_string($elC)){
            $elC = $this->getElement($elC);
        }

        return $elC;
    }

    public function clearValidation(){
        $this->validation = null;
        $this->isValid = true;
    }

    public function render($elm,$attributes = null){

        $elC = $this->__parseElement($elm);

        if(!$elC){
            if(is_string($elm))
                throw new Exception('Element with ID='.$elm.' is not part of the form');
            else
                throw new Exception('the given arg is not renderable by render context');
        }

        $el = $elC->getElement();

        $values = self::__getNavigator()->arrayGet($this->data,$this->data,$elC->getPrename(true));

        return $el->render($attributes , $values , $this->data , $elC->getPrename());

    }


    /**
     * @param $string
     * @return ElementContext
     */
    public function getElement($string){
        
        if(isset($this->elements[$string]) )
            return $this->elements[$string];

        return null;

    }


    /**
     * @param $string
     * @return ElementContext[]
     */
    public function getChildren($el){

        $el = $this->__parseElement($el);
        
        if(!$el){
            return false;
        }else{
            return $el->getChildren();
        }
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
