<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validation;

use UForm\Environment;
use UForm\Validation\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Message
     */
    protected $message;

    public function setUp()
    {
        $this->message = new Message(
            "message width: %_width_%; height: %_height_%",
            ["width" => 10, "height" => 20, "foo" => "bar"],
            "TestMessage"
        );
    }

    public function testGetType()
    {
        $this->assertEquals("TestMessage", $this->message->getType());
    }

    public function testGetMessageRaw()
    {
        $this->assertEquals("message width: %_width_%; height: %_height_%", $this->message->getMessageRaw());
    }

    public function testGetProcessedMessage()
    {
        $this->assertEquals("message width: 10; height: 20", $this->message->getProcessedMessage());
    }

    public function testGetVariables()
    {
        $this->assertEquals(["width" => 10, "height" => 20, "foo" => "bar"], $this->message->getVariables());
    }

    public function testToString()
    {
        $this->assertEquals("message width: 10; height: 20", (string) $this->message);
    }

    public function testSetVariablePlaceholderBefore()
    {
        $message = new Message(
            "message width: {{width_%; height: %_height_%",
            ["width" => 10, "height" => 20, "foo" => "bar"],
            "TestMessage"
        );
        $message->setVariablePlaceholderBefore("{{");
        $this->assertEquals("message width: 10; height: %_height_%", $message->getProcessedMessage());
    }

    public function testSetVariablePlaceholderAfter()
    {
        $message = new Message(
            "message width: %_width}}; height: %_height_%",
            ["width" => 10, "height" => 20, "foo" => "bar"],
            "TestMessage"
        );
        $message->setVariablePlaceholderAfter("}}");
        $this->assertEquals("message width: 10; height: %_height_%", $message->getProcessedMessage());
    }

    public function testSetTranslator()
    {
        $message = new Message("Some message");
        $this->assertSame(Environment::getTranslator(), $message->getTranslator());

        $translator = new Message\DefaultTranslator();
        $message->setTranslator($translator);

        $this->assertSame($translator, $message->getTranslator());
    }
}
