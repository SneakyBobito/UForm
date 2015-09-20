<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Builder;

use UForm\Builder\FluentElement;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\Text;

class FluentElementTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var FluentElement
     */
    protected $fluentElementStub;

    /**
     * @var Group
     */
    protected $parentGroup;

    public function setUp()
    {
        $this->fluentElementStub = $this->getMockForTrait("UForm\Builder\FluentElement");
        $this->parentGroup = new Group();
        $this->fluentElementStub->open($this->parentGroup);
    }

    public function testAdd()
    {
        $element = new Text("t");
        $output = $this->fluentElementStub->add($element);
        $this->assertSame($element, $this->fluentElementStub->last());
        $this->assertSame($this->parentGroup, $element->getParent());
        $this->assertSame($this->fluentElementStub, $output);

        $element2 = new Text("t2");
        $this->fluentElementStub->add($element2);
        $this->assertSame($element2, $this->fluentElementStub->last());

        $this->fluentElementStub->close();
        $this->setExpectedException("UForm\Builder\BuilderException");
        $this->fluentElementStub->add(new Text("t3"));

    }

    public function testOpen()
    {
        $group = new Group();
        $output = $this->fluentElementStub->open($group);
        $this->assertSame($group, $this->fluentElementStub->current());
        $this->assertSame($this->fluentElementStub, $output);

        $group2 = new Group();
        $this->fluentElementStub->open($group2);
        $this->assertSame($group2, $this->fluentElementStub->current());
    }

    public function testClose()
    {
        $group = new Group();
        $output = $this->fluentElementStub->open($group);
        $this->assertSame($this->fluentElementStub, $output);
        $this->assertSame($group, $this->fluentElementStub->current());
        $this->fluentElementStub->close();
        $this->assertSame($this->parentGroup, $this->fluentElementStub->current());

        $this->fluentElementStub->close();
        $this->assertNull($this->fluentElementStub->current());
        $this->setExpectedException("UForm\Builder\BuilderException");
        $this->fluentElementStub->close();
    }

    public function testCurrent()
    {
        $this->assertSame($this->parentGroup, $this->fluentElementStub->current());
    }

    public function testLast()
    {
        $this->assertNull($this->fluentElementStub->last());
        $element = new Text("test");
        $this->fluentElementStub->add($element);
        $this->assertSame($element, $this->fluentElementStub->last());
    }

    public function testOption()
    {
        $element = new Text("test");
        $this->fluentElementStub->add($element);
        $this->fluentElementStub->option("testOption", "value");
        $this->assertEquals("value", $element->getOption("testOption"));
    }
}
