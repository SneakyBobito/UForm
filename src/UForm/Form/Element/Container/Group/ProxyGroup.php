<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container\Group;

use UForm\Filtering\FilterChain;
use UForm\Form\Element\Container\Group;

/**
 * A proxy group is used to proxify all validation and filtering to a given element.
 * A proxy acts as a group but does not have a concrete name.
 * Thus it does not modify the namespace of descendant elements
 *
 * A concrete usage case is as a radio group: it will gather radios in one radio group
 * that will take validators and filters. Then validation messages will be shown in the proxy and not in the radio
 * and it wont modify the name of other elements (for instance you want to have radio and input text in the same group)
 */
class ProxyGroup extends Group
{

    protected $proxyName;

    public function __construct($proxyName = null)
    {
        parent::__construct(null);
        $this->proxyName = $proxyName;
    }

    public function prepareFilterChain(FilterChain $filterChain)
    {
        parent::prepareFilterChain($filterChain);



        $filterChain->addFiltersFor($this->getProxyName(true), $this->getFilters());
    }

    public function getProxyName($withNamespace = false)
    {

        if (!$withNamespace) {
            return $this->proxyName;
        }

        if ($this->prename) {
            $name = $this->prename . '.' . $this->proxyName;
        } else {
            $name = $this->proxyName;
        }
        return $name;
    }
}
