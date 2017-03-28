<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validator;

use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator;
use UForm\Validator\Csrf\CsrfInterface;

/**
 * validate the value against the given csrfInterface
 */
class Csrf extends Validator
{

    /**
     * @validationMessage triggered when a csrf token is not valid
     */
    const NOT_VALID = 'Csrf::NOT_VALID';

    /**
     * @var CsrfInterface
     */
    protected $csrfInterface;

    public function __construct(CsrfInterface $csrfInterface)
    {
        $this->csrfInterface = $csrfInterface;
        parent::__construct();
    }


    /**
     * @inheritdoc
     */
    public function validate(ValidationItem $validationItem)
    {
        if (!$this->csrfInterface->tokenIsValid($validationItem->getValue())) {
            $message = new Message('Csrf token is not valid', [], self::NOT_VALID);
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
