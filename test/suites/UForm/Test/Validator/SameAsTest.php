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
        $validation = $this->generateValidationItem(['firstname' => 'bart', 'lastname' => 'bart']);
        $validator = new SameAs('lastname');
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(['firstname' => 'bart', 'lastname' => 'simpsons']);
        $validator = new SameAs('lastname');
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $this->assertCount(1, $validation->getMessages());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(SameAs::DIFFERENT, $message->getType());
        $this->assertSame('firstname', $message->getVariables()['tested-field']);
        $this->assertSame('lastname', $message->getVariables()['compare-field']);
    }
}
