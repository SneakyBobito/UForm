<?php

namespace UForm\Form\Element\Container\Group;

use UForm\Exception;
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

    protected $values;

    /**
     *
     * @param string $name name of the checkbox. Just type "name" and it will generate some "name[]"
     * @param array $values list of checkboxes to create
     * @throws \UForm\Exception
     */
    public function __construct($name, $values)
    {

        $elements = [];

        $i = 0;

        foreach ($values as $k => $v) {
            if (is_string($v) || is_int($v)) {
                $elements[] = new Check($k, $v);
            } else {
                throw new Exception("Invalid type for checkgroup creation");
            }
            $i++;
        }

        parent::__construct($name, $elements);
        $this->addSemanticType("checkGroup");
    }
}
