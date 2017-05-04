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
        $validation = $this->generateValidationItem(['firstname' => 'bart', 'lastname' => 'bart']);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testValidArray()
    {
        $validation = $this->generateValidationItem(['firstname' => ['bart'], 'lastname' => 'bart']);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testNotValidNotPresent()
    {
        $validation = $this->generateValidationItem(['lastname' => 'simpsons']);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $this->assertCount(1, $validation->getMessages());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(Required::REQUIRED, $message->getType());
    }

    public function testNotValidEmtpy()
    {
        $validation = $this->generateValidationItem(['firstname' => '', 'lastname' => 'simpsons']);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $this->assertCount(1, $validation->getMessages());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(Required::REQUIRED, $message->getType());
    }

    public function testNotValidEmtpyArray()
    {
        $validation = $this->generateValidationItem(['firstname' => [], 'lastname' => 'simpsons']);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $this->assertCount(1, $validation->getMessages());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(Required::REQUIRED, $message->getType());
    }

    public function testValidZero()
    {
        $validation = $this->generateValidationItem(['firstname' => 0, 'lastname' => 'simpsons']);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => '0', 'lastname' => 'simpsons']);
        $validator = new Required();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }
}
