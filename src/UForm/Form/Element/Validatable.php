<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element;

use UForm\Validation\ValidationItem;

interface Validatable
{

    public function checkValidity(ValidationItem $validationItem);
}
