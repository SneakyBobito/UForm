<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator;

use UForm\FileUpload;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

class IsFile extends Validator
{
    const NOT_A_FILE = "IsFile::NOT_A_FILE";

    public function validate(ValidationItem $validationItem)
    {
        if (!$validationItem->getValue() instanceof FileUpload) {
            $message = new Message("The data sent is not a valid file", [], self::NOT_A_FILE);
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
