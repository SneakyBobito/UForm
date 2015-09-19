<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\ValidationItem;
use UForm\Validator;

class StringLength extends Validator
{

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

        if ($this->minLength > 0 && strlen($value) < $this->minLength) {
            $validationItem->appendMessage(
                $this->getOption('string-too-short', 'String too short (less than %_length_% character)'),
                null,
                ["length" => $this->minLength]
            );
            return false;
        }
        if ($this->maxLength > 0 && strlen($value) > $this->maxLength) {
            $validationItem->appendMessage(
                $this->getOption('string-too-short', 'String too long (more than %_length_% character)'),
                null,
                ["length" => $this->maxLength]
            );
            return false;
        }


        return true;
    }
}
