<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\Validator;

class Required extends Validator
{
    
    /**
     * @inheritdoc
     */
    public function validate(Validation $validator)
    {
        
        $value = $validator->getLocalData();

        if (!isset($value[$validator->getLocalName()]) || null === $value[$validator->getLocalName()]) {
            $validator->appendMessage($this->getOption('message'));
            return false;
        }

        return true;
    }
}
