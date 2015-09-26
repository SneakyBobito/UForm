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
        $this->assertTrue($validator->validate($validation));
    }

    public function testTooShort()
    {
        $validator = new StringLength(10, 20);
        $validation = $this->generateValidationItem(["firstname" => "short"]);
        $this->assertFalse($validator->validate($validation));

        $this->assertSame(StringLength::TOO_SHORT, $validation->getMessages()->getAt(0)->getType());
        $this->assertSame(10, $validation->getMessages()->getAt(0)->getVariables()["min-length"]);
        $this->assertSame(5, $validation->getMessages()->getAt(0)->getVariables()["string-length"]);
    }

    public function testTooLong()
    {
        $validator = new StringLength(3, 5);
        $validation = $this->generateValidationItem(["firstname" => "verylongstring"]);
        $this->assertFalse($validator->validate($validation));

        $this->assertSame(StringLength::TOO_LONG, $validation->getMessages()->getAt(0)->getType());
        $this->assertSame(5, $validation->getMessages()->getAt(0)->getVariables()["max-length"]);
        $this->assertSame(14, $validation->getMessages()->getAt(0)->getVariables()["string-length"]);
    }
}
