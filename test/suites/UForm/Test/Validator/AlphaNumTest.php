<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\AlphaNum;

/**
 * @covers UForm\Validator\AlphaNum
 */
class AlphaNumTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validation = $this->generateValidationItem(["firstname" => "bart1"]);
        $validator = new AlphaNum();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());


        $validation = $this->generateValidationItem(["firstname" => "bart 1"]);
        $validator = new AlphaNum(true);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(["firstname" => "bart-1"]);
        $validator = new AlphaNum();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());


        $validation = $this->generateValidationItem(["firstname" => "bart 1"]);
        $validator = new AlphaNum();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }

    public function testEmpty()
    {

        $validation = $this->generateValidationItem(["firstname" => ""]);
        $validator = new AlphaNum();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

    }
}
