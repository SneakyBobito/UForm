<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Primary\Structural;

use UForm\Form\Element\Primary\Structural;

class Divider extends Structural
{

    public function __construct()
    {
        parent::__construct();
        $this->addSemanticType('divider');
    }
}
