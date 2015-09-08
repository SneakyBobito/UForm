<?php

namespace UForm\Validation\Validator;

use \UForm\Validation\Validator,
	\UForm\Validation;


class Required extends Validator{
    
    /**
     * @inheritdoc
     */
    public function validate(Validation $validator){
        
        $value = $validator->getLocalData();

        if(!isset($value[$validator->getLocalName()]) || null === $value[$validator->getLocalName()] ){
            $validator->appendMessage($this->getOption('message'));
            return false;
        }

        return true;
    }
}