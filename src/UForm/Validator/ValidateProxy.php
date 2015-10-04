<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator;

use UForm\Form\Element;
use UForm\Validation\ValidationItem;
use UForm\Validation\ValidationItemBridge;
use UForm\Validator;

/**
 * Acts like a proxy for validator. It will process validator as usually,
 * but messages and error will be attached to the given element
 */
class ValidateProxy extends Validator
{

    protected $validatedElement;
    protected $validator;

    /**
     * @param Element $validatedElement the element that will receive the error
     * @param Validator $validator the validator
     */
    public function __construct(Element $validatedElement, Validator $validator)
    {
        $this->validatedElement = $validatedElement;
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {
        $elementInternalName = $this->validatedElement->getInternalName(true);
        $validationOutput = $validationItem->getChainedValidation()->getValidation($elementInternalName, true);
        $validationBridge = new ValidationItemBridge($validationItem, $validationOutput);
        $this->validator->validate($validationBridge);
    }
}
