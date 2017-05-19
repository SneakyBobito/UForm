<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Validator\IsValid;

/**
 * That's the most basic builder. It allows to create elements in a fluent way
 */
trait FluentElement
{

    protected $stack = [];
    /**
     * @var null|Group
     */
    protected $currentGroup = null;

    /**
     * @var Element|null
     */
    protected $lastElement = null;

    /**
     * an element to add to the form
     * @param Element $element
     * @throws BuilderException
     * @return $this;
     */
    public function add(Element $element)
    {

        if (!$this->currentGroup) {
            throw new BuilderException(
                'Call to add() impossible, no group opened,' .
                "you probably didn't open a group or you closed to many groups"
            );
        }

        $this->currentGroup->addElement($element);
        $this->lastElement = $element;

        if ($element instanceof Element\Validatable) {
            $element->addValidator(new IsValid());
        }

        return $this;
    }


    /**
     * Open the given group, next elements added by the builder will be added to this group until he is closed
     * @param Group $e
     * @return $this
     */
    public function open(Group $e)
    {
        if ($this->currentGroup) {
            $this->stack[] = $this->currentGroup;
        }
        $this->currentGroup = $e;
        return $this;
    }

    /**
     * Close the last opened Group
     * @return $this
     * @throws BuilderException
     */
    public function close()
    {
        if (!$this->currentGroup) {
            throw new BuilderException('Group stack is empty, call to close() requires a stack to be opened');
        }
        $this->currentGroup = array_pop($this->stack);
        return $this;
    }

    /**
     * get the currently opened group
     * @return Group
     */
    public function current()
    {
        return $this->currentGroup;
    }

    /**
     * Get the last created element
     *
     * @return Element the latest element
     * @throws BuilderException
     */
    public function last()
    {
        if (!$this->lastElement) {
            throw new BuilderException('No last element');
        }
        return $this->lastElement;
    }

    /**
     * Set option to the last element
     * @see \UForm\Form\Element::setOption()
     * @param string $option name of the option
     * @param string $value value of the option
     * @return $this
     */
    public function option($option, $value)
    {
        $last = $this->last();
        $last->setOption($option, $value);
        return $this;
    }


    /**
     * Adds an helper that serves to give additional informations to the user
     * @param $text
     * @return $this
     * @throws BuilderException
     */
    public function helper($text)
    {
        try {
            $this->last()->setOption('helper', $text);
        } catch (BuilderException $e) {
            throw new BuilderException('helper() call requires you already added an element to the builder', 0, $e);
        }
        return $this;
    }

    /**
     * Adds a tooltip that serves to give additional informations to the user
     * @param $text
     * @return $this
     * @throws BuilderException
     */
    public function tooltip($text)
    {
        try {
            $this->last()->setOption('tooltip', $text);
        } catch (BuilderException $e) {
            throw new BuilderException('tooltip() call requires you already added an element to the builder', 0, $e);
        }
        return $this;
    }

    /**
     * Sets the id of the last element
     * @param string $id id of the element
     * @return $this
     * @throws BuilderException
     */
    public function id($id)
    {
        try {
            $this->last()->setId($id);
        } catch (BuilderException $e) {
            throw new BuilderException('id() call requires you already added an element to the builder', 0, $e);
        }
        return $this;
    }

    /**
     * Adds a css class to the element
     * @param $className
     * @return $this
     * @throws BuilderException
     */
    public function addClass($className)
    {
        try {
            $this->last()->addClass($className);
        } catch (BuilderException $e) {
            throw new BuilderException('id() call requires you already added an element to the builder', 0, $e);
        }
        return $this;
    }
}
