<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\Regexp;

/**
 * @covers UForm\Validator\Regexp
 */
class RegexpTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validation = $this->generateValidationItem(['firstname' => 'bart']);
        $validator = new Regexp('#^[a-z]+$#');
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testCustomMessage()
    {
        $validation = $this->generateValidationItem(['firstname' => 'Bart']);
        $validator = new Regexp('#^[a-z]+$#', 'must be alpha lower case');
        $validator->validate($validation);
        $this->assertEquals('must be alpha lower case', $validation->getMessages()->getAt(0)->getMessageRaw());
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(['firstname' => 'Bart']);
        $validator = new Regexp('#^[a-z]+$#');
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }
}
