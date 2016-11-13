<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\Validation\ValidationItem;
use UForm\Validator;

class StringLength extends Validator
{

    const TOO_SHORT = 'StringLength::TOO_SHORT';
    const TOO_LONG  = 'StringLength::TOO_LONG';

    private $minLength;
    private $maxLength;

    public function __construct($minLength = 0, $maxLength = 0, $options = [])
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;

        parent::__construct($options);
    }


    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {
        $value = $validationItem->getValue();
        $length = strlen($value);

        if ($this->minLength > 0 && $length < $this->minLength) {
            $message = new Validation\Message(
                'String too short (less than %_min-length_% character)',
                ['min-length' => $this->minLength, 'string-length' => $length ],
                self::TOO_SHORT
            );
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        } elseif ($this->maxLength > 0 && $length > $this->maxLength) {
            $message = new Validation\Message(
                'String too long (more than %_max-length_% character)',
                ['max-length' => $this->maxLength, 'string-length' => $length ],
                self::TOO_LONG
            );
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
