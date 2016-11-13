<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container;

use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\Text;

class GroupTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {

        $group = new Group();
        $this->assertNull($group->getName());
        $this->assertSame([], $group->getElements());
        $this->assertTrue($group->hasSemanticType('group'));

        $group = new Group('name');
        $this->assertEquals('name', $group->getName());
        $this->assertSame([], $group->getElements());
    }

    public function testAddElement()
    {
        $text1 = new Text('firstname');
        $text2 = new Text('lastname');
        $group = new Group();

        $group->addElement($text1);
        $this->assertSame([$text1], $group->getElements());

        $group->addElement($text2);
        $this->assertSame([$text1, $text2], $group->getElements());
    }

    public function testGetName()
    {

        $group = new Group();
        $this->assertNull($group->getName());

        $group->setName('name');
        $this->assertSame('name', $group->getName());

        $group->setNamespace('namespace');

        $this->assertSame('namespace.name', $group->getName(true, true));
    }

    public function testGetElement()
    {
        $text1 = new Text('firstname');
        $group = new Group();
        $group2 = new Group('phones');
        $phone1 = new Text('phone1');
        $phone2 = new Text('phone2');

        $group->addElement($text1);
        $group->addElement($group2);
        $group2->addElement($phone1);
        $group2->addElement($phone2);

        $this->assertSame($text1, $group->getElement('firstname'));
        $this->assertSame($phone2, $group->getElement('phones.phone2'));
        $this->assertSame($phone1, $group->getElement('phones.phone1'));

        $this->setExpectedException('UForm\InvalidArgumentException');
        $group->getElement(new \stdClass());
    }
}
