<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\FileUpload;
use UForm\Form;
use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Requirable;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Form\Element\Validatable;

/**
 * File input
 * @semanticType input:file
 */
class File extends Input implements Requirable, Validatable
{

    const NOT_VALID_NOT_A_FILE = 'File::NOT_A_FILE';

    protected $accept;
    protected $multiple;

    /**
     * File constructor.
     * @param string $name
     * @param bool $multiple whether or not multiple file can be selected
     * @param string $accept file type to accept @link http://www.w3schools.com/tags/att_input_accept.asp
     *
     */
    public function __construct($name, $multiple = false, $accept = null)
    {

        // TODO multiple can be a number
        // TODO more validation (file type, mime type, image size, ...)

        parent::__construct('file', $name);
        $this->multiple = $multiple;
        $this->accept = $accept;
        $this->addSemanticType('input:file');
    }

    public function refreshParent()
    {
        parent::refreshParent();
        if ($this->form) {
            $this->form->setEnctype(Form::ENCTYPE_MULTIPART_FORMDATA);
        }
    }

    /**
     * @return null|string
     */
    public function getAccept()
    {
        return $this->accept;
    }



    protected function overridesParamsBeforeRender($params, $value)
    {
        unset($params['value']);

        if ($this->multiple) {
            $params['multiple'] = true;
        }

        if ($this->accept) {
            $params['accept'] = $this->accept;
        }

        return $params;
    }


    public function isDefined(ValidationItem $validationItem)
    {
        return $validationItem->getValue() !== null;
    }

    public function checkValidity(ValidationItem $validationItem)
    {
        $value = $validationItem->getValue();

        if (!$value instanceof FileUpload && $value !== null) {
            $message = new Message('The data sent is not a valid file', [], self::NOT_VALID_NOT_A_FILE);
            $validationItem->appendMessage($message);
            $validationItem->setInvalid();
        }
    }
}
