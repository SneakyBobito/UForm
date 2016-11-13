<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator;

use UForm\Exception;
use UForm\FileUpload;
use UForm\Form\Element\Validatable;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * Special validator to be used on @see UForm\Form\Element\Validatable
 */
class IsValid extends Validator
{

    public function validate(ValidationItem $validationItem)
    {
        if ($validationItem->getElement() instanceof Validatable) {
            $validationItem->getElement()->checkValidity($validationItem);
        } else {
            throw new Exception('Element is not validatable. It must be an instance of UForm\Form\Element\Validatable');
        }
    }
}
