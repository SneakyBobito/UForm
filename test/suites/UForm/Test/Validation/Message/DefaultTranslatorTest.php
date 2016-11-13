<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validation\Message;

use UForm\Validation\Message;
use UForm\Validation\Message\DefaultTranslator;

class DefaultTranslatorTest extends \PHPUnit_Framework_TestCase
{


    public function testTranslate()
    {
        $message = new Message('Message %_variable_%', ['variable' => 'foo']);
        $translator = new DefaultTranslator();
        $translated = $translator->translate($message);

        $this->assertEquals('Message foo', $translated);
    }
}
