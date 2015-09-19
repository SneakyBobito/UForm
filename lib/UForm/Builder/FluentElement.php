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

    public function add(Element $e)
    {
        $this->currentGroup->addElement($e);
        $this->lastElement = $e;
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
        if (count($this->stack) == 0) {
            throw new BuilderException("Group stack is empty, call to close() requires a stack to be opened");
        }
        $this->currentGroup = array_pop($this->stack);
        return $this;
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
            throw new BuilderException("Call to last() requires you to have already created an element");
        }
        return $this->lastElement;
    }
}
