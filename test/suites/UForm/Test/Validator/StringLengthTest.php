<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Form;
use UForm\Test\ValidatorTestCase;
use UForm\Validation\Message;
use UForm\Validator\StringLength;

class StringLengthTest extends ValidatorTestCase
{

    public function testValid()
    {

        $validator = new StringLength(1, 20);
        $validation = $this->generateValidationItem(["firstname" => "bart"]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testTooShort()
    {
        $validator = new StringLength(10, 20);
        $validation = $this->generateValidationItem(["firstname" => "short"]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $this->assertSame(StringLength::TOO_SHORT, $validation->getMessages()->getAt(0)->getType());
        $this->assertSame(10, $validation->getMessages()->getAt(0)->getVariables()["min-length"]);
        $this->assertSame(5, $validation->getMessages()->getAt(0)->getVariables()["string-length"]);
    }

    public function testTooLong()
    {
        $validator = new StringLength(3, 5);
        $validation = $this->generateValidationItem(["firstname" => "verylongstring"]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $this->assertCount(1, $validation->getMessages());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(StringLength::TOO_LONG, $message->getType());
        $this->assertSame(5, $message->getVariables()["max-length"]);
        $this->assertSame(14, $message->getVariables()["string-length"]);
    }
}
