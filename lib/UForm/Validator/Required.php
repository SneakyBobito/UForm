<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\ValidationItem;
use UForm\Validator;

class Required extends Validator
{
    
    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {
        
        $value = $validationItem->getLocalData();

        if (!isset($value[$validationItem->getLocalName()]) || null === $value[$validationItem->getLocalName()]) {
            $validationItem->appendMessage($this->getOption('message'));
            return false;
        }

        return true;
    }
}
