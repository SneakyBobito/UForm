<?php

/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container;

use UForm\DataContext;
use UForm\Form\Element;
use UForm\Form\Element\Container;
use UForm\Form\FormContext;

/**
 * Collection
 *
 * @author sghzal
 * @semanticType collection
 */
class Collection extends Container
{

    /**
     * @var \UForm\Form\Element
     */
    protected $elementDefinition;
    protected $min;
    protected $max;





    public function __construct($name, Element $elementDefinition, $min = 1, $max = -1)
    {
        parent::__construct($name);
        $this->elementDefinition = $elementDefinition;
        $this->min = $min;
        $this->max = $max;
        $this->elementDefinition->setName(null);
        $this->addSemanticType("collection");
    }


    public function prepareValidation(DataContext $localValues, FormContext $formContext)
    {
        parent::prepareValidation($localValues, $formContext);
        $value = $localValues->getDirectValue($this->getName());
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $element = $this->__getElemement($k);
                $element->prepareValidation(new DataContext($value), $formContext);
            }
        }
    }


    // CLONED INSTANCES CONTAINER
    private $internalElementClones;

    /**
     * @param $index
     * @return Element|null
     */
    private function __getElemement($index)
    {
        if (!$this->internalElementClones) {
            $this->internalElementClones = [];
        }

        if (!isset($this->internalElementClones[$index])) {
            $element = clone $this->elementDefinition;
            $element->setName($index);
            $element->setParent($this);
            $element->setInternalName($index);
            $this->internalElementClones[$index] = $element;
        }

        return $this->internalElementClones[$index];
    }

    /**
     * @inheritdoc
     */
    public function getElement($name)
    {
        return $this->elementDefinition;
    }


    /**
     * @inheritdoc
     */
    public function getElements($values = null)
    {

        if (!$values) {
            return [];
        }

        $el = [];

        if (isset($values[$this->getName()]) && is_array($values[$this->getName()])) {
            $realValues = $values[$this->getName()];
            foreach ($realValues as $k => $v) {
                $el[] = $this->__getElemement($k);
            }
        }
        return $el;
    }
}
