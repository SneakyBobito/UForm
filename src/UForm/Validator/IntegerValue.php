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
    const TOO_LARGE   = 'IntegerValue::TOO_LARGE';
    const TOO_SMALL   = 'IntegerValue::TOO_SMALL';

    protected $min;
    protected $max;

    /**
     * IntegerValue constructor.
     * @param $min
     * @param $max
     */
    public function __construct($min = null, $max = null, $options = [])
    {
        $this->min = $min;
        $this->max = $max;

        parent::__construct($options);
    }


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
        } else {
            if (null !== $this->min && $this->min > $value) {
                $message = new Message(
                    'Number too small (minimum is %_min_%)',
                    ['min' => $this->min],
                    self::NOT_INTEGER
                );

                $validationItem->appendMessage($message);
                $validationItem->setInvalid();
            } elseif (null !== $this->max && $this->max < $value) {
                $message = new Message(
                    'Number too large (maximum is %_max_%)',
                    ['max' => $this->max],
                    self::NOT_INTEGER
                );

                $validationItem->appendMessage($message);
                $validationItem->setInvalid();
            }
        }
    }
}
