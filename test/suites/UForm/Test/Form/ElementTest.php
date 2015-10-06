<?php

namespace UForm\Test\Form;

use UForm\Form;
use UForm\Form\Element;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Container\Group\NamedGroup\Panel;

/**
 * @covers UForm\Form\Element
 */
class ElementTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Element
     */
    protected $elementStub;

    public function test()
    {
    }

    protected function setUp()
    {
        $this->elementStub = $this->getMockForAbstractClass('UForm\Form\Element');
    }

    public function testConstructor()
    {


        $elementName = "elementName";
        $attributes = ["at1" => "val1", "at2" => "val2"];
        $validators = [
            $this->getMockForAbstractClass('UForm\Validator'),
            $this->getMockForAbstractClass('UForm\Validator')
        ];
        $filters= [$this->getMockForAbstractClass('UForm\Filter'), $this->getMockForAbstractClass('UForm\Filter')];

        /* @var $element Element */
        $element = $this->getMockForAbstractClass('UForm\Form\Element', [
            $elementName, $attributes, $validators, $filters
        ]);

        $this->assertEquals($elementName, $element->getName());
        $this->assertSame($attributes, $element->getAttributes());
        $this->assertSame($validators, $element->getValidators());
        $this->assertSame($filters, $element->getFilters());
    }

    public function testGetClosestParent()
    {
        $this->assertNull($this->elementStub->getClosestInstanceOf("UForm\Element\Container"));

        $group = new Group();
        $group->addElement($this->elementStub);

        $this->assertSame($group, $this->elementStub->getClosestInstanceOf("UForm\Form\Element\Container"));

        $panel = new Panel();
        $panel->addElement($group);
        $this->assertSame($group, $this->elementStub->getClosestInstanceOf("UForm\Form\Element\Container"));
        $this->assertSame($panel, $this->elementStub->getClosestInstanceOf("UForm\Form\Element\Container\Group\NamedGroup\Panel"));
    }


    public function testAddClass()
    {
        $this->elementStub->addClass("first");
        $this->assertEquals(["class" => "first"], $this->elementStub->getAttributes());

        $this->elementStub->addClass("second");
        $this->assertEquals(["class" => "first second"], $this->elementStub->getAttributes());
    }

    public function testSetParent()
    {
        $form = new Form();
        $parent = new Element\Container\Group();

        $form->addElement($parent);

        $this->elementStub->setParent($parent);

        $this->assertEquals($parent, $this->elementStub->getParent());
        $this->assertEquals($form, $this->elementStub->getForm());

    }

    public function testGetForm()
    {
        $this->assertEquals(null, $this->elementStub->getForm());
    }

    public function testSetId()
    {
        $id = "someid";
        $this->elementStub->setId($id);
        $this->assertSame("someid", $this->elementStub->getId());
    }

    public function testGetId()
    {
        $id = $this->elementStub->getId();
        $this->assertNotNull($this->elementStub->getId());
        $this->assertSame($id, $this->elementStub->getId());

        $this->elementStub->setId(null);
        $id = $this->elementStub->getId();
        $this->assertNotNull($this->elementStub->getId());
        $this->assertSame($id, $this->elementStub->getId());
    }

    public function testGetParent()
    {
        $this->assertEquals(null, $this->elementStub->getParent());
    }

    public function testSetName()
    {
        $this->assertEquals(null, $this->elementStub->getName());
        $this->elementStub->setName("newName");
        $this->assertEquals("newName", $this->elementStub->getName());
        $this->elementStub->setName("otherName");
        $this->assertEquals("otherName", $this->elementStub->getName());
    }

    public function testGetName()
    {
        $this->assertEquals(null, $this->elementStub->getName());

        $this->elementStub->setName("newName");
        $this->assertEquals("newName", $this->elementStub->getName(false, false));
        $this->assertEquals("newName", $this->elementStub->getName(true, false));
        $this->assertEquals("newName", $this->elementStub->getName(true, true));
        $this->assertEquals("newName", $this->elementStub->getName(false, true));


        $this->elementStub->setNamespace("parentName");
        $this->assertEquals("newName", $this->elementStub->getName(false, false));
        $this->assertEquals("parentName[newName]", $this->elementStub->getName(true, false));
        $this->assertEquals("parentName.newName", $this->elementStub->getName(true, true));
        $this->assertEquals("newName", $this->elementStub->getName(false, true));

    }

    public function testGetInternalName()
    {
        $this->assertEquals(null, $this->elementStub->getName());

        $this->elementStub->setName("newName");
        $this->assertEquals(null, $this->elementStub->getInternalName(false));
        $this->assertEquals(null, $this->elementStub->getInternalName(true));

        $this->elementStub->setInternalName("internalName");
        $this->elementStub->setInternalNamespace("parentInternalName");
        $this->assertEquals("internalName", $this->elementStub->getInternalName(false));
        $this->assertEquals("parentInternalName.internalName", $this->elementStub->getInternalName(true));
    }

    public function testSetAttribute()
    {
        $this->elementStub->setAttribute("atr1", "value1");
        $this->elementStub->setAttribute("atr2", "value2");
        $this->assertEquals(["atr1" => "value1", "atr2" => "value2"], $this->elementStub->getAttributes());

        $this->setExpectedException("UForm\InvalidArgumentException");
        $this->elementStub->setAttribute([], "val");
    }

    public function testGetAttributes()
    {
        $this->assertEquals([], $this->elementStub->getAttributes());

        $this->setExpectedException("UForm\InvalidArgumentException");
        $this->elementStub->getAttribute([]);
    }

    public function testAddAttributes()
    {
        $this->elementStub->setAttribute("atr1", "value1");
        $this->elementStub->addAttributes(["atr2" => "value2", "atr3" => "value3"]);
        $this->assertEquals(
            ["atr1" => "value1", "atr2" => "value2", "atr3" => "value3"],
            $this->elementStub->getAttributes()
        );

        $this->setExpectedException("UForm\InvalidArgumentException");
        $this->elementStub->addAttributes("fake");
    }

    public function testGetAttribute()
    {
        $this->assertEquals("defaultValue", $this->elementStub->getAttribute("atr1", "defaultValue"));
        $this->assertEquals(null, $this->elementStub->getAttribute("atr1"));

        $this->elementStub->setAttribute("atr1", "value1");
        $this->assertEquals("value1", $this->elementStub->getAttribute("atr1", "defaultValue"));
    }
}
