<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\ValidationItem;
use UForm\Validator;

class Required extends Validator
{

    const REQUIRED = "Required::Required";

    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {

        $value = $validationItem->getLocalData()->getDataCopy();


        if (!is_array($value)
            || !isset($value[$validationItem->getLocalName()])
            || null === $value[$validationItem->getLocalName()]
        ) {
            $message = new Validation\Message("Field is required", [], self::REQUIRED);
            $validationItem->appendMessage($message);
            return false;
        }

        return true;
    }
}
