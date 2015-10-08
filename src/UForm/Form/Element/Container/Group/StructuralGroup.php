<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group;

/**
 * A structural group does not have a name.
 * Filters and validators cant be added to a structural group
 */
class StructuralGroup extends Group
{

    public function __construct()
    {
        parent::__construct(null);
        $this->addSemanticType("structuralGroup");
    }
}
