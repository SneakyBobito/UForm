<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Input;

use UForm\Form;
use UForm\Form\Element\Primary\Input;

/**
 * Class File
 * @semanticType input:file
 */
class File extends Input
{
    public function __construct($name)
    {
        parent::__construct("file", $name);
        $this->addSemanticType("input:file");
    }

    public function refreshParent()
    {
        parent::refreshParent();
        if ($this->form) {
            $this->form->setEnctype(Form::ENCTYPE_MULTIPART_FORMDATA);
        }
    }
}
