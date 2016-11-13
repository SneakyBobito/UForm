<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Builder;

use UForm\Builder;
use UForm\Builder\GroupBuilder;
use UForm\Form\Element\Container\Group;

/**
 * @covers UForm\Builder\GroupBuilder
 */
class GroupBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var GroupBuilder
     */
    protected $groupBuilderStub;

    public function setUp()
    {
        $this->groupBuilderStub = new Builder();
    }

    public function testGroup()
    {
        $this->groupBuilderStub->group('groupName');
        $this->assertInstanceOf('UForm\Form\Element\Container\Group', $this->groupBuilderStub->current());
        $this->assertTrue($this->groupBuilderStub->last() === $this->groupBuilderStub->current());
        $this->assertEquals('groupName', $this->groupBuilderStub->last()->getName());
    }

    public function testColumn()
    {

        $this->groupBuilderStub->columnGroup();
        $this->groupBuilderStub->column(6);
        $className = 'UForm\Form\Element\Container\Group\Structural\Column';
        $this->assertInstanceOf($className, $this->groupBuilderStub->current());
        $this->assertTrue($this->groupBuilderStub->last() === $this->groupBuilderStub->current());
        $this->assertEquals(6, $this->groupBuilderStub->last()->getWidth());


        $this->setUp();
        $this->setExpectedException('UForm\Builder\BuilderException');
        $this->groupBuilderStub->column(6);
    }

    public function testColumnGroup()
    {
        $this->groupBuilderStub->columnGroup();
        $this->assertInstanceOf(
            'UForm\Form\Element\Container\Group\Structural\ColumnGroup',
            $this->groupBuilderStub->current()
        );
        $this->assertTrue($this->groupBuilderStub->last() === $this->groupBuilderStub->current());
    }

    public function testPanel()
    {
        $this->groupBuilderStub->panel('panelTitle');
        $this->assertInstanceOf(
            'UForm\Form\Element\Container\Group\Structural\Panel',
            $this->groupBuilderStub->current()
        );
        $this->assertTrue($this->groupBuilderStub->last() === $this->groupBuilderStub->current());
        $this->assertEquals('panelTitle', $this->groupBuilderStub->current()->getOption('title'));
    }

    public function testFieldset()
    {
        $this->groupBuilderStub->fieldset('fieldsetTitle');
        $this->assertInstanceOf(
            'UForm\Form\Element\Container\Group\Structural\Fieldset',
            $this->groupBuilderStub->current()
        );
        $this->assertTrue($this->groupBuilderStub->last() === $this->groupBuilderStub->current());
        $this->assertEquals('fieldsetTitle', $this->groupBuilderStub->current()->getOption('title'));
    }

    public function testTab()
    {
        $this->groupBuilderStub->tabGroup();
        $this->groupBuilderStub->tab('tabTitle');
        $this->assertInstanceOf(
            'UForm\Form\Element\Container\Group\Structural\Tab',
            $this->groupBuilderStub->current()
        );
        $this->assertTrue($this->groupBuilderStub->last() === $this->groupBuilderStub->current());
        $this->assertEquals('tabTitle', $this->groupBuilderStub->last()->getOption('title'));


        $this->setUp();
        $this->setExpectedException('UForm\Builder\BuilderException');
        $this->groupBuilderStub->tab();
    }

    public function testTabGroup()
    {
        $this->groupBuilderStub->tabGroup();
        $className = 'UForm\Form\Element\Container\Group\Structural\TabGroup';
        $this->assertInstanceOf($className, $this->groupBuilderStub->current());
        $this->assertTrue($this->groupBuilderStub->last() === $this->groupBuilderStub->current());
    }
}
