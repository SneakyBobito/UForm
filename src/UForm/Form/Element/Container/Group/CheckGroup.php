<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\Check;

/**
 * Class CheckGroup
 * @semanticType checkGroup
 *
 * @method Check[] getElements($values = null)
 */
class CheckGroup extends Group
{

    /**
     *
     * @param string $name name of the checkbox. Just type "name" and it will generate some "name[]"
     * @param array $values list of checkboxes to create
     * @throws \UForm\Exception
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $this->addSemanticType("checkGroup");
    }
}
