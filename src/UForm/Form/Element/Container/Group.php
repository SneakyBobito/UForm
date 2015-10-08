<?php
/**
 * @license see LICENSE
 */

namespace UForm\Form\Element\Container;

use UForm\DataContext;
use UForm\Form\Element;
use UForm\Form\Element\Container;
use UForm\Form\FormContext;
use UForm\InvalidArgumentException;

/**
 * Group that can contains many elements.
 *
 * A group can be used for namespacing form values or for grouping
 * elements into columns, tabs...
 *
 * @semanticType group
 */
class Group extends Container
{

    /**
     * @var \UForm\Form\Element[]
     */
    protected $elements = [];

    /**
     * @param null|string $name name of the group. A group name can be null to allow transparent grouping
     * @param Element|Element[] $elements one or many elements to add to the group
     */
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->addSemanticType("group");
    }

    /**
     * adds an element to the group
     * @param Element $element the element to add
     */
    public function addElement(Element $element)
    {
        $iname = "i" . count($this->elements);
        $this->elements[$iname] = $element;
        $element->setParent($this);
        $element->setInternalName($iname);
    }

    /**
     * @inheritdoc
     */
    public function getName($prenamed = null, $dottedNotation = false)
    {
        if (null === $this->name) {
            return $this->prename;
        }

        return  parent::getName($prenamed, $dottedNotation);
    }

    /**
     * @inheritdoc
     */
    public function getElement($name)
    {

        if (is_array($name)) {
            $namesP = $name;
        } elseif (is_string($name)) {
            $namesP = explode(".", $name);
        } else {
            throw new InvalidArgumentException('name', 'string', $name);
        }


        $finalElm = $this->getDirectElement($namesP[0]);

        if ($finalElm && count($namesP)>1) {
            array_shift($namesP);
            return $finalElm->getElement(($namesP));
        }
        return $finalElm;
    }


    /**
     * Get elements in the group
     * @param null $values
     * @return \UForm\Form\Element[]
     */
    public function getElements($values = null)
    {
        return array_values($this->elements);
    }


    /**
     * @inheritdoc
     */
    public function prepareValidation(DataContext $localValues, FormContext $formContext)
    {
        parent::prepareValidation($localValues, $formContext);
        $name = $this->getName();
        foreach ($this->getElements() as $k => $v) {
            if ($name) {
                $values = $localValues->getDirectValue($name);
            } else {
                $values = $localValues->getDataCopy();
            }
            $v->prepareValidation(new DataContext($values), $formContext);
        }
    }
}
