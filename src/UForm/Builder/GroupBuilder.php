<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\Column;
use UForm\Form\Element\Container\Group\ColumnGroup;
use UForm\Form\Element\Container\Group\NamedGroup\Fieldset;
use UForm\Form\Element\Container\Group\NamedGroup\Panel;
use UForm\Form\Element\Container\Group\NamedGroup\Tab;
use UForm\Form\Element\Container\Group\Row;
use UForm\Form\Element\Container\Group\TabGroup;

trait GroupBuilder
{

    /**
     * @see FluentElement::add()
     * @return $this
     */
    abstract public function add(Element $e);

    /**
     * @see FluentElement::open()
     * @return $this
     */
    abstract public function open(Group $e);

    /**
     * @see FluentElement::close()
     * @return $this
     */
    abstract public function close();

    /**
     * @see FluentElement::last()
     * @return $this
     */
    abstract public function last();

    /**
     * @see FluentElement::current()
     * @return $this
     */
    abstract public function current();

    /**
     * Adds a named group that wont render but that intend to serve for grouping form data in an array
     * @param string $name name of the group that will serve as key in the data array
     * @return $this
     */
    public function group($name)
    {
        $element = new Group($name);
        $this->add($element);
        $this->open($element);
        return $this;
    }

    /**
     * Adds a column. Requires a column group to be opened
     * @param int $width width of the column
     * @return $this
     * @throws BuilderException
     */
    public function column($width)
    {
        if (!$this->current() instanceof ColumnGroup) {
            throw new BuilderException("Cant call builder::column() outside of a columnGroup Element");
        }
        $element = new Column($width);
        $this->add($element);
        $this->open($element);
        return $this;
    }

    /**
     * Adds a column group to the form
     * @return $this
     */
    public function columnGroup()
    {
        $element = new ColumnGroup();
        $this->add($element);
        $this->open($element);
        return  $this;
    }

    /**
     * Add an Inline group to the form
     * @return $this
     */
    public function inline()
    {
        $element = new Group\Inline();
        $this->add($element);
        $this->open($element);
        return $this;
    }

    /**
     * Adds a panel
     * @param string $title title of the panel
     * @return $this
     */
    public function panel($title = null)
    {
        $element = new Panel($title);
        $this->add($element);
        $this->open($element);
        return $this;
    }

    /**
     * Adds a fieldset
     * @param string $title title of the panel
     * @return $this
     */
    public function fieldset($title = null)
    {
        $element = new Fieldset($title);
        $this->add($element);
        $this->open($element);
        return $this;
    }


    /**
     * Adds a row
     * @return $this
     */
    public function row()
    {
        $element = new Row();
        $this->add($element);
        $this->open($element);
        return  $this;
    }

    /**
     * Adds a tab group that will allow to setup some tabs inside
     *
     * You can specify additional options for rendering.
     * Be aware that options may not be considered by all render engines
     *
     * <pre>
     *      $options = [
     *          "tab-style" => "tab"  // "pills" is also a valid option for boostrap render
     *          "tab-position" => "top" // also accept "bottom", "left", "right"
     *          "tab-justified" => false // pass it to true to have tab justified in bootstrap3
     *      ]
     * </pre>
     *
     * @param array $options
     * @return $this
     */
    public function tabGroup($options = [])
    {
        $element = new TabGroup();
        foreach ($options as $name => $value) {
            $element->setOption("tabgroup-$name", $value);
        }
        $this->add($element);
        $this->open($element);
        return  $this;
    }

    /**
     * Adds a tab. Requires a tabGroup to be currently opened
     * @param string $title title of the tab
     * @param string $active pass to true to set this tab currently active
     * @return $this
     * @throws BuilderException
     */
    public function tab($title = null, $active = false)
    {
        if (!$this->current() instanceof TabGroup) {
            throw new BuilderException("Cant call builder::tab() outside of a tabgroup Element");
        }
        $element = new Tab($title);
        if ($active) {
            $element->setOption("tab-active", true);
        }
        $this->add($element);
        $this->open($element);
        return  $this;
    }
}
