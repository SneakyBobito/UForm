<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;

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
                "Call to add() impossible, no group opened," .
                "you probably didn't open a group or you closed to many groups"
            );
        }

        $this->currentGroup->addElement($element);
        $this->lastElement = $element;

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
            throw new BuilderException("Group stack is empty, call to close() requires a stack to be opened");
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
     */
    public function last()
    {
        if (!$this->lastElement) {
            return null;
        }
        return $this->lastElement;
    }

    /**
     * Set option to the last element
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
}
