<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\SameAs;

class SameAsTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validation = $this->generateValidationItem(["firstname" => "bart", "lastname" => "bart"]);
        $validator = new SameAs("lastname");
        $this->assertTrue($validator->validate($validation));
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(["firstname" => "bart", "lastname" => "simpsons"]);
        $validator = new SameAs("lastname");
        $this->assertFalse($validator->validate($validation));

        $this->assertCount(1, $validation->getMessages());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(SameAs::DIFFERENT, $message->getType());
        $this->assertSame("firstname", $message->getVariables()["tested-field"]);
        $this->assertSame("lastname", $message->getVariables()["compare-field"]);
    }
}
