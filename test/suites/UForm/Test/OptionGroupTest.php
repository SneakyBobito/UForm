<?php

namespace UForm\Test;

use UForm\OptionGroup;

class OptionGroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var OptionGroup
     */
    protected $optionGroup;

    public function setup()
    {
        $this->optionGroup = $this->getMockForTrait('UForm\OptionGroup');
    }

    public function testSetOption()
    {
        $this->optionGroup->setOption('foo', 'bar');
        $this->assertEquals('bar', $this->optionGroup->getOption('foo'));
    }

    public function testGetOption()
    {
        $this->assertEquals('baz', $this->optionGroup->getOption('foo', 'baz'));
        $this->assertNull($this->optionGroup->getOption('foo'));
        $this->optionGroup->setOption('foo', 'bar');
        $this->assertEquals('bar', $this->optionGroup->getOption('foo'));
        $this->assertEquals('bar', $this->optionGroup->getOption('foo', 'baz'));
    }

    public function testAddOptions()
    {
        $this->optionGroup->addOptions(['foo' => 'bar', 'qux' => 'quux']);
        $this->assertSame(['foo' => 'bar', 'qux' => 'quux'], $this->optionGroup->getOptions());

        $this->optionGroup->addOptions([]);
        $this->assertSame(['foo' => 'bar', 'qux' => 'quux'], $this->optionGroup->getOptions());

        $this->optionGroup->addOptions([ 'qux' => 'qux', 'toto' => 'titi']);
        $this->assertSame(['foo' => 'bar', 'qux' => 'qux', 'toto' => 'titi'], $this->optionGroup->getOptions());
    }

    public function testHasOption()
    {
        $this->optionGroup->addOptions(['foo' => 'bar', 'qux' => 'quux']);
        $this->assertTrue($this->optionGroup->hasOption('foo'));
        $this->assertFalse($this->optionGroup->hasOption('bar'));
        $this->assertTrue($this->optionGroup->hasOption('qux'));
    }


    public function testSetOptions()
    {
        $this->optionGroup->setOptions(['foo' => 'bar', 'qux' => 'quux']);
        $this->assertSame(['foo' => 'bar', 'qux' => 'quux'], $this->optionGroup->getOptions());

        $this->optionGroup->setOptions([]);
        $this->assertSame([], $this->optionGroup->getOptions());

        $this->optionGroup->setOptions([ 'qux' => 'qux', 'toto' => 'titi']);
        $this->assertSame(['qux' => 'qux', 'toto' => 'titi'], $this->optionGroup->getOptions());

        $this->optionGroup->setOptions(null);
        $this->assertSame([], $this->optionGroup->getOptions());
    }

    public function testGetOptions()
    {
        $this->assertEquals([], $this->optionGroup->getOptions());
    }
}
