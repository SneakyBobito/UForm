<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator;

use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

class IntegerValue extends Validator
{
    const NOT_INTEGER = 'IntegerValue::NOT_INTEGER';

    public function validate(ValidationItem $validationItem)
    {
        $value = $validationItem->getValue();

        if (!is_numeric($value) || !(int)$value == $value) {
            $message = new Message(
                'Not a valid number',
                [],
                self::NOT_INTEGER
            );

            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
