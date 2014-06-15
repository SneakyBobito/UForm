<?php

namespace UForm\Validation\Validator;

use \UForm\Validation\Validator,
	\UForm\Validation\Message,
	\UForm\Validation\Exception,
	\UForm\Validation;


class Required extends Validator
{
    /**
     * Executes the validation
     *
     * @param \UForm\Validation $validator
     * @param string $attribute
     * @return boolean
     * @throws Exception
     */
    public function validate(Validation $validator){
        
        $value = $validator->getLocalData();
        
        if(!isset($value[$validator->getLocalName()]) || !$value[$validator->getLocalName()] ){
            $validator->appendMessage($this->getOption('message'));
            return false;
        }

        return true;
    }
}