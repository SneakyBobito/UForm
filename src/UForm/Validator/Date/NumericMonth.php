<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator\Date;

use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * Checks that the given value is a valid numeric month  [0-11] or [1-12]
 */
class NumericMonth extends Validator
{
    const NOT_NUMERIC_MONTH = 'NumericMonth::NOT_NUMERIC_MONTH';

    protected $zeroIndexed;

    /**
     * NumericMonth constructor.
     * @param $zeroIndexed
     */
    public function __construct($zeroIndexed = false)
    {
        $this->zeroIndexed = $zeroIndexed;
        parent::__construct([]);
    }


    public function validate(ValidationItem $validationItem)
    {
        $value = $validationItem->getValue();

        $i = $this->zeroIndexed ? 0 : 1;

        if (!is_numeric($value) || $value < 0 + $i || $value > 11 + $i) {
            $validationItem->appendMessage(new Message(
                'Month is not valid.',
                [],
                self::NOT_NUMERIC_MONTH
            ));
            $validationItem->setInvalid();
        }
    }
}
