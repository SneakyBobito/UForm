<?php

namespace UForm\Validator;

use UForm\Validation;
use UForm\Validation\ValidationItem;
use UForm\Validator;

class AlphaNum extends Validator
{

    const NOT_ALPHANUM = "AlphaNum::NOT_ALPHANUM";

    protected $allowSpaces;

    public function __construct($allowSpaces = false, array $options = [])
    {
        parent::__construct($options);
        $this->allowSpaces = $allowSpaces;
    }


    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {
        $data = $validationItem->getValue();

        if ($this->allowSpaces) {
            $data = preg_replace('/\s/', '', $data);
        }

        if (!ctype_alnum($data)) {
            $message = new Validation\Message(
                "The value must only contain alpha numeric characters",
                [],
                self::NOT_ALPHANUM
            );

            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
