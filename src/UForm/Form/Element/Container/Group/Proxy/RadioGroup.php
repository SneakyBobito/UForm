<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group\Proxy;

use UForm\Form\Element\Container\Group\ProxyGroup;
use UForm\Form\Element\Primary\Input\Radio;
use UForm\Form\Element\ValueRangeInterface;

class RadioGroup extends ProxyGroup implements ValueRangeInterface
{

    public function __construct($proxyName = null)
    {
        parent::__construct($proxyName);
        $this->addSemanticType('radioGroup');
    }

    public function valueIsInRange($data)
    {

        if (isset($data[$this->proxyName])) {
            $elements = $this->getDirectElements($this->getProxyName(), $data);
            $value = $data[$this->proxyName];

            foreach ($elements as $element) {
                if ($element instanceof Radio && $element->getValue() == $value) {
                    return true;
                }
            }
        }
        return false;
    }
}
