<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\ValidationItem;
use UForm\Validator;

/**
 * SameAs
 * usefull for same password checking
 */
class SameAs extends Validator
{
    
    protected $sameElement = null;


    public function __construct($sameAs, $options = null)
    {
        $this->sameElement = $sameAs;
        parent::__construct($options);
    }

    
    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {
        
        $value1 = $validationItem->getValue();
        $value2 = $validationItem->getValue($this->sameElement);
        
        if ($value2 !== $value1) {
            $validationItem->appendMessage($this->getOption('message'));
            return false;
        }

        return true;
    }
}
