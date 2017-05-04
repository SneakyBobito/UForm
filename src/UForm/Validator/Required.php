<?php

namespace UForm\Validator;

use UForm\Form\Element\Requirable;
use UForm\Validation;
use UForm\Validation\ValidationItem;
use UForm\Validator;

/**
 * Ensures that the given field is present in the dataset
 *
 * By default it checks that the element is present is the dataset and not ``null``
 *
 * The way elements are checked can be different for each element. To do so the element
 * has to implement @see UForm\Form\Element\Requirable and then the check of the element will be used instead
 */
class Required extends Validator
{

    const REQUIRED = 'Required::Required';

    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {

        $value = $validationItem->getLocalData()->getDataCopy();

        $element = $validationItem->getElement();

        if ($element instanceof Requirable) {
            $valid = $element->isDefined($validationItem);
        } else {
            $localName = $validationItem->getLocalName();
            $valid = is_array($value)
                && isset($value[$localName])
                && null !== $value[$localName]
                && (
                    !empty($value[$localName])
                    || 0 === $value[$localName]
                    || '0' === $value[$localName]
                );
        }

        if (!$valid) {
            $message = new Validation\Message('Field is required', [], self::REQUIRED);
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }

        return true;
    }
}
