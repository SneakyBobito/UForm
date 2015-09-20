<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validation\Message;


use UForm\Validation\Message;
use UForm\Validation\Message\Group;

class GroupTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Group
     */
    protected $group;

    public function setUp(){
        $this->group = new Group();
    }


    public function testAppendMessage(){
        $message = new Message("test");
        $this->group->appendMessage($message);
        $this->assertSame($message, $this->group->getAt(0));

        $message = new Message("test");
        $this->group->appendMessage($message);
        $this->assertSame($message, $this->group->getAt(1));
    }


    public function testGetAt(){
        $this->assertNull($this->group->getAt(0));
    }

    public function testAppendMessages(){
        $message = new Message("test");
        $this->group->appendMessage($message);
        $this->assertSame($message, $this->group->getAt(0));

        $message2 = new Message("test2");
        $message3 = new Message("test3");

        $this->group->appendMessages([$message2, $message3]);
        $this->assertSame($message2, $this->group->getAt(1));
        $this->assertSame($message3, $this->group->getAt(2));
    }

    public function testCount(){
        $this->assertCount(0, $this->group);

        $message = new Message("test");
        $this->group->appendMessage($message);
        $this->assertCount(1, $this->group);

        $message = new Message("test");
        $this->group->appendMessage($message);
        $this->assertCount(2, $this->group);
    }

    public function testGetIterator(){
        $message = new Message("test");
        $this->group->appendMessage($message);
        $this->assertInstanceOf("ArrayIterator", $this->group->getIterator());
        $this->assertEquals([$message], $this->group->getIterator()->getArrayCopy());
    }
}
