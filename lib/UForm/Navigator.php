<?php

namespace UForm;


use UForm\Forms\ElementContainer;
use UForm\Forms\Form;
use UForm\Navigator\Exception;

class Navigator {


    /**
     *
     * Gets an element from the form
     *
     * Usefull for doted notation eg : 'elm.subelm.0.name'
     *
     * @param Form $form
     * @param $string
     * @throws Navigator\Exception
     */
    public function formGet(Form $form,$string){

        $stringParts = explode("." , $string);

        $actual = $form->get(array_shift($stringParts));

        while( !empty($stringParts) ){

            if($actual instanceof ElementContainer){

                $actual = $actual->getElement(array_shift($stringParts));

            }else{
                throw new Exception("element should be a group (usualy collection or group)");
            }

        }

        return $actual;

    }
    
    public function arrayGet($local,$global,$string){
        
        $stringParts = explode(".", $string);
        
        
        if( "." === $string{0} )
            $actual = $local;
        else
            $actual = $global;
        
        
        while (!empty($stringParts)){
            $newName = array_shift($stringParts);
            if(!isset($actual[$newName])){
                return null;
            }else{
                $actual = $actual[$newName];
            }
        }
        
        return $actual;
        
    }


} 