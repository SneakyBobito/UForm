<?php

/**
 * @copyright (c) Rock A Gogo VPC
 */


namespace UForm;


use UForm\Forms\ElementInterface;

class ElementContext {

    /**
     * @var ElementInterface
     */
    protected $element;
    protected $prename;

    function __construct($element, $prename)
    {
        $this->element = $element;
        $this->prename = explode(".",$prename);
    }

    /**
     * @return \UForm\Forms\ElementInterface
     */
    public function getElement()
    {
        return $this->element;
    }


    public function getName(){
        return $this->element->getName();
    }

    public function getFullName($dottedNotation = false){
        return $this->element->getName($this->getPrename($dottedNotation) , $dottedNotation );
    }

    /**
     * @return mixed
     */
    public function getPrename($dotted = false)
    {

        if($dotted)
            return implode(".",$this->prename);
        else{

            $prenamePieces = $this->prename;

            $prename = array_shift($prenamePieces);

            if(count($prenamePieces)>0){
                foreach($prenamePieces as $v){
                    $prename.="[$v]";
                }
            }

            return $prename;
        }
    }




}