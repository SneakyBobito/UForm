<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator\Date;

use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * Checks that the given value is a valid day of the month
 */
class DayOfMonth extends Validator
{
    const NOT_DAY_OF_MONTH = 'DayOfMonth::NOT_DAY_OF_MONTH';

    public function validate(ValidationItem $validationItem)
    {
        $value = $validationItem->getValue();

        if (!is_numeric($value) || $value < 1 || $value > 31) {
            $validationItem->appendMessage(new Message(
                'Day of the month is not valid',
                [],
                self::NOT_DAY_OF_MONTH
            ));
            $validationItem->setInvalid();
        }
    }
}
