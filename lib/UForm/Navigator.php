<?php

namespace UForm;


use UForm\Forms\Element\Collection;
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

            if($actual instanceof ElementContainer || $actual instanceof Collection){
                $actual = $actual->getElement(array_shift($stringParts));
            }else{
                throw new Exception("element should be a group (usualy collection or group)");
            }

        }

        return $actual;

    }

    /**
     * @param array $local  locals values (context aware). Most of time same as $global
     * @param array $global   the whole data (not context aware)
     * @param string $string  the navigation string. e.g : "foo.bar.0". If begins with a dot e.g ".bar.0" the local context context will be use or else we use the global one.
     * @param int $rOffset  the reversed offset default 0. With the string "foo.bar.0" | $rOffset=0 will get "foo.bar.0"  |  $rOffset=1 will get "foo.bar" |  $rOffset=2 will get "foo"
     * @return null
     */
    public function arrayGet($local,$global,$string,$rOffset = 0){

        if( is_null($string) || empty($string)){
            return $global;
        }

        $stringParts = explode(".", $string);

        if($rOffset>0){
            for($i=0;$i<$rOffset;$i++){
                array_pop($stringParts);
            }
        }
        
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