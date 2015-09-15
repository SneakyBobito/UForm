<?php


namespace UForm\Forms\Group\Bootstrap;


use UForm\Forms\Group\NamedGroup;

/**
 * Class Panel
 * @package UForm\Forms\Group\Bootstrap
 * @semanticType bootstrap:panel
 */
class Panel extends NamedGroup {

    public function __construct($name = null)
    {
        parent::__construct("div", $name, null);
        $this->addSemanticType("bootstrap:panel");
    }

}