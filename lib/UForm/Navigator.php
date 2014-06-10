<?php

namespace UForm;


use UForm\Forms\ElementContainer;
use UForm\Forms\Form;
use UForm\Navigator\Exception;

class Navigator {



    public function formGet(Form $form,$string){

        $stringParts = explode("." , $string);

        $actual = $form->get(array_shift($stringParts));

        while( !empty($stringParts) ){

            if($actual instanceof ElementContainer){

                $actual->getElement(array_shift($stringParts));

            }else{
                throw new Exception("element should be a group (usualy collection or group)");
            }

        }

    }


} 