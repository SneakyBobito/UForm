<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group\Proxy;

use UForm\Form\Element\Container\Group\ProxyGroup;

class RadioGroup extends ProxyGroup
{

    public function __construct($proxyName = null)
    {
        parent::__construct($proxyName);
        $this->addSemanticType("radioGroup");
    }
}
