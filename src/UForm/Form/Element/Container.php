<?php

namespace UForm\Form\Element;

use UForm\Filtering\FilterChain;
use UForm\Form\Element;

/**
 * Element that intends to contain other elements.
 * It only aims to be a common parent for Group and Collection
 *
 * In some ways it is opposed to the Primary element that cant contain other elements
 *
 * @see UForm\Form\Element\Container\Group
 * @see UForm\Form\Element\Container\Collection
 * @see UForm\Form\Element\Container\Primary

 * @semanticType container
 */
abstract class Container extends Element
{

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->addSemanticType('container');
    }

    /**
     * Get an element by its name
     * @param $name
     * @return Element
     */
    abstract public function getElement($name);

    /**
     * Get the elements contained in this container.
     * Values are required because a collection requires values to be generated
     * @param mixed $values used for the "collection" element that is rendered according to a value set
     * @return Element[] the elements contained in this container
     */
    abstract public function getElements($values = null);


    /**
     * Get an element located directly in this element. There is an exception for unnamed elements :
     * we will search inside directElements of unnamed elements
     * @param string $name name of the element to get
     * @param mixed $values used for the "collection" element that is rendered according to a value set
     * @return null|Element|Container the element found or null if the element does not exist
     */
    public function getDirectElement($name, $values = null)
    {
        foreach ($this->getElements($values) as $elm) {
            if ($name == $elm->getName()) {
                return $elm;
            } elseif (!$elm->getName() && $elm instanceof Container) {
                /* @var $elm \UForm\Form\Element\Container */
                $element = $elm->getDirectElement($name);
                if ($element) {
                    return $element;
                }
            }
        }
        return null;
    }

    /**
     * Get direct elements with the given name
     * @param $name
     * @param null $values
     * @return Element[]
     */
    public function getDirectElements($name, $values = null)
    {

        $elements = [];

        foreach ($this->getElements($values) as $elm) {
            if ($name == $elm->getName()) {
                $elements[] = $elm;
            } elseif (!$elm->getName() && $elm instanceof Container) {
                /* @var $elm \UForm\Form\Element\Container */
                $elements += $elm->getDirectElements($name, $values);
            }
        }

        return $elements;
    }

    /**
     * check if this element contains at least one element that is an instance of the given type
     * @param string $className the name of the class to search for
     * @return bool true if the instance was found
     */
    public function hasDirectElementInstance($className)
    {
        foreach ($this->getElements() as $el) {
            if (is_a($el, $className)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if this element contains at least one element with the given semantic type
     * @param string $type the type to search for
     * @return bool true if the semantic type was found
     */
    public function hasDirectElementSemanticType($type)
    {
        foreach ($this->getElements() as $el) {
            if ($el->hasSemanticType($type)) {
                return true;
            }
        }
        return false;
    }

    public function prepareFilterChain(FilterChain $filterChain)
    {
        parent::prepareFilterChain($filterChain);
        foreach ($this->getElements() as $v) {
            $v->prepareFilterChain($filterChain);
        }
    }

    /**
     * @inheritdoc
     */
    public function setParent(Container $parent)
    {
        $r = parent::setParent($parent);
        foreach ($this->getElements() as $element) {
            $element->refreshParent();
        }
        return $r;
    }
}
