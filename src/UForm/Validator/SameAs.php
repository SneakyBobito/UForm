<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * SameAs
 * usefull for same password checking
 */
class SameAs extends Validator
{

    const DIFFERENT = 'SameAs::DIFFERENT';

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
        $value2 = $validationItem->findValue($this->sameElement);

        if ($value2 !== $value1) {
            $message = new Validation\Message(
                'Fields %_tested-field_% and %_compare-field_% have different values',
                [
                    'tested-field' => $validationItem->getElement()->getName(true, true),
                    'compare-field' => $this->sameElement
                ],
                self::DIFFERENT
            );

            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
