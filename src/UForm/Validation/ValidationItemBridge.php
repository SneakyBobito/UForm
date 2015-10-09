<?php
/**
 * @license see LICENSE
 */

namespace UForm\Validation;

use UForm\Form\Element;

class ValidationItemBridge extends ValidationItem
{

    /**
     * @var ValidationItem
     */
    protected $bridgeOutput;

    public function __construct(ValidationItem $inputValidation, ValidationItem $ouputValidation)
    {
        parent::__construct(
            $inputValidation->getLocalData(),
            $inputValidation->getElement(),
            $inputValidation->getFormContext()
        );
        $this->bridgeOutput = $ouputValidation;
    }

    /**
     * @inheritdoc
     */
    public function setInvalid()
    {
        $this->bridgeOutput->setInvalid();
    }

    /**
     * @inheritdoc
     */
    public function appendMessage($message, $elementName = null)
    {
        $this->bridgeOutput->appendMessage($message, $elementName);
    }
}
