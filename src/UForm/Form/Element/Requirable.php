<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element;

use UForm\Validation\ValidationItem;

/**
 * Elements that implement this interface provide a custom check for @see UForm\Validator\Required validator
 */
interface Requirable
{

    public function isDefined(ValidationItem $validationItem);
}
