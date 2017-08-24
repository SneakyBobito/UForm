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

    /**
     * @param string $sameAs name of the element the must have the same value
     * @param null $options
     *
     */
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
                'Fields are not identical',
                $this->getOptions(),
                self::DIFFERENT
            );

            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
