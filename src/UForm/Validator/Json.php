<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\Validation\ValidationItem;
use UForm\Validator;

class Json extends Validator
{

    const INVALID_JSON_STRING = 'Json::INVALID_JSON_STRING';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {
        $value = $validationItem->getValue();

        json_decode($value);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = new Validation\Message('Invalid json string', [], self::INVALID_JSON_STRING);
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
