<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\Required;

class RequiredTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validation = $this->generateValidationItem(["firstname" => "bart", "lastname" => "bart"]);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(["lastname" => "simpsons"]);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $this->assertCount(1, $validation->getMessages());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(Required::REQUIRED, $message->getType());
    }
}
