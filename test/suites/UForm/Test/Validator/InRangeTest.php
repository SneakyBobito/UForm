<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\InRange;

/**
 * @covers UForm\Validator\InRange
 */
class InRangeTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validation = $this->generateValidationItem(['firstname' => 'bart']);
        $validator = new InRange(['bart', 'homer']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(['firstname' => 'marge']);
        $validator = new InRange(['bart', 'homer']);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }
}
