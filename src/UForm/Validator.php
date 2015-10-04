<?php

namespace UForm;

use UForm\Validation\Message;
use UForm\Validation\ValidationItem;

/**
 * This is a base class for validators
 */
abstract class Validator
{

    use OptionGroup;

    /**
     * \UForm\Validation\Validator constructor
     *
     * @param array|null $options
     * @throws Exception
     */
    public function __construct($options = null)
    {
        $this->setOptions($options);
    }
    /**
     * Executes the validation
     *
     * @param ValidationItem $validationItem
     * @return boolean true if validation was successful
     * @throws Exception
     */
    abstract public function validate(ValidationItem $validationItem);
}
