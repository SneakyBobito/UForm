<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator;

use UForm\FileUpload;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * Check whether the value is null or a file
 *
 * To ensure that the value is not null, you will need to use the @see UForm\Validator\Required validator in addition
 *
 * This validator is added automatically by the builder when you add a file input
 *
 * <code>
 * // creates a file input and add the validator IsFile but the file is not mandatory
 * $builder->file("someFile");
 *
 * // creates a file input and makes it mandatory
 * $builder->file("otherFile")->required();
 * </code>
 *
 */
class IsFile extends Validator
{
    const NOT_A_FILE = "IsFile::NOT_A_FILE";

    public function validate(ValidationItem $validationItem)
    {

        $value = $validationItem->getValue();

        if (!$value instanceof FileUpload && $value !== null) {
            $message = new Message("The data sent is not a valid file", [], self::NOT_A_FILE);
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
