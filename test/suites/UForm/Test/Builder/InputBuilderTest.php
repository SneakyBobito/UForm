<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Builder;

use UForm\Builder;
use UForm\Form\Element\Container\Group;

class InputBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Builder\InputBuilder
     */
    protected $inputBuilderStub;

    /**
     * @var Group
     */
    protected $parentGroup;

    public function setUp()
    {
        $this->inputBuilderStub = new Builder();

    }

    public function testText()
    {
        $this->inputBuilderStub->text("inputName", "inputTitle");
        $this->assertInstanceOf("UForm\Form\Element\Primary\Input\Text", $this->inputBuilderStub->last());
        $this->assertEquals("inputName", $this->inputBuilderStub->last()->getName());
        $this->assertEquals("inputTitle", $this->inputBuilderStub->last()->getOption("title"));
    }

    public function testTextArea()
    {
        $this->inputBuilderStub->textArea("inputName", "inputTitle");
        $this->assertInstanceOf("UForm\Form\Element\Primary\TextArea", $this->inputBuilderStub->last());
        $this->assertEquals("inputName", $this->inputBuilderStub->last()->getName());
        $this->assertEquals("inputTitle", $this->inputBuilderStub->last()->getOption("title"));
    }

    public function testPassword()
    {
        $this->inputBuilderStub->password("inputName", "inputTitle");
        $this->assertInstanceOf("UForm\Form\Element\Primary\Input\Password", $this->inputBuilderStub->last());
        $this->assertEquals("inputName", $this->inputBuilderStub->last()->getName());
        $this->assertEquals("inputTitle", $this->inputBuilderStub->last()->getOption("title"));
    }

    public function testSelect()
    {
        $this->inputBuilderStub->select("inputName", "inputTitle");
        $this->assertInstanceOf("UForm\Form\Element\Primary\Select", $this->inputBuilderStub->last());
        $this->assertEquals("inputName", $this->inputBuilderStub->last()->getName());
        $this->assertEquals("inputTitle", $this->inputBuilderStub->last()->getOption("title"));
    }

    public function testHidden()
    {
        $this->inputBuilderStub->hidden("inputName", "inputTitle");
        $this->assertInstanceOf("UForm\Form\Element\Primary\Input\Hidden", $this->inputBuilderStub->last());
        $this->assertEquals("inputName", $this->inputBuilderStub->last()->getName());
    }
    public function testFile()
    {
        $this->inputBuilderStub->file("inputName", "inputTitle");
        $this->assertInstanceOf("UForm\Form\Element\Primary\Input\File", $this->inputBuilderStub->last());
        $this->assertEquals("inputName", $this->inputBuilderStub->last()->getName());
    }

    public function testLeftAddon()
    {
        $this->inputBuilderStub
            ->text("text")
            ->leftAddon("left");
        $this->assertEquals("left", $this->inputBuilderStub->last()->getOption("leftAddon"));

        $this->setUp();
        $this->setExpectedException("UForm\Builder\BuilderException");
        $this->inputBuilderStub->leftAddon("leftAddon");

    }

    public function testRightAddon()
    {
        $this->inputBuilderStub
            ->text("text")
            ->rightAddon("right");
        $this->assertEquals("right", $this->inputBuilderStub->last()->getOption("rightAddon"));

        $this->setUp();
        $this->setExpectedException("UForm\Builder\BuilderException");
        $this->inputBuilderStub->rightAddon("rightAddon");
    }
}
