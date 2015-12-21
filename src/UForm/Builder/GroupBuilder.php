<?php
/**
 * @license see LICENSE
 */

namespace UForm\Builder;

use UForm\Filter\DefaultValue;
use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\Proxy\RadioGroup;
use UForm\Form\Element\Container\Group\Structural\Column;
use UForm\Form\Element\Container\Group\Structural\ColumnGroup;
use UForm\Form\Element\Container\Group\Structural\Fieldset;
use UForm\Form\Element\Container\Group\Structural\Inline;
use UForm\Form\Element\Container\Group\Structural\Panel;
use UForm\Form\Element\Container\Group\Structural\Tab;
use UForm\Form\Element\Container\Group\Structural\TabGroup;
use UForm\Validator\InRange;

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
        $element = new Inline();
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
     * Adds a tab group that will allow to setup some tabs inside
     *
     * You can specify additional options for rendering.
     * Be aware that options may not be considered by all render engines
     *
     * <pre>
     *      $options = [
     *          "tab-position" => "top" // also accept "bottom", "left", "right"
     *          "tab-justified" => false // pass it to true to have tab justified
     *      ]
     * </pre>
     *
     * @param array $options
     * @return $this
     */
    public function tabGroup($options = [])
    {
        $element = new TabGroup();
        $element->addOptions($options);
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


    /**
     * Adds a radio group that can contain any kind of element. Only radios with the same name will be considered in
     * this group. It will also automatically add a validator the restrict the value to be one of the radio's value
     *
     * Note that the name of the radio group does not modify the name of children elements.
     *
     * <code>
     * $form = Builder::init()
     *   ->radioGroup("radioName", "defaultValue")
     *      ->radio("radioName", "defaultValue", "some label")
     *      ->radio("radioName", "secondValue", "some label")
     *      ->radio("radioName", "thirdValue", "some label")
     *   ->close()
     *   ->getForm();
     * </code>
     *
     * @see Uform\Form\Element\Input\Radio
     * @param string $name name of the radio to take into the group. This name wont modify the namespace of children
     * @param string $defaultValue value of the radio that will be checked by default
     * @return $this
     */
    public function radioGroup($name, $defaultValue = null)
    {
        $element = new RadioGroup($name);
        $this->add($element);
        $this->open($element);

        $element->addValidator(new InRange($element));

        if ($defaultValue) {
            $element->addFilter(new DefaultValue($defaultValue));
        }

        return $this;
    }
}
