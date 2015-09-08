<?php

namespace UForm\Validation\Validator;

use \UForm\Validation\Validator,
	\UForm\Validation;


class AlphaNum extends Validator{

    function __construct($options = [])
    {
        parent::__construct($options);
    }


    /**
     * @inheritdoc
     */
    public function validate(Validation $validator){

        $value = $validator->getValue();

        if(!ctype_alnum($value)){
            $validator->appendMessage(
                $this->getOption('error', 'Should only contain letter or number')
            );
            return false;
        }

        return true;
    }
}