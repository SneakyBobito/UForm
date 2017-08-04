<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\AlphaNum;
use UForm\Validator\IntegerValue;

/**
 * @covers UForm\Validator\AlphaNum
 */
class IntergerValueTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validation = $this->generateValidationItem(['firstname' => '1']);
        $validator = new IntegerValue();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());


        $validation = $this->generateValidationItem(['firstname' => 1]);
        $validator = new IntegerValue();
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(['firstname' => 'bart-1']);
        $validator = new IntegerValue();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());


        $validation = $this->generateValidationItem(['firstname' => '1-bart']);
        $validator = new IntegerValue();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }

    public function testEmpty()
    {

        $validation = $this->generateValidationItem(['firstname' => '']);
        $validator = new IntegerValue();
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }

    public function testMin()
    {
        $validator = new IntegerValue(1);

        $validation = $this->generateValidationItem(['firstname' => 5]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => 1]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());


        $validation = $this->generateValidationItem(['firstname' => -1]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => 0]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }

    public function testMax()
    {
        $validator = new IntegerValue(null, 5);

        $validation = $this->generateValidationItem(['firstname' => 5]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => 1]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => -1]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => 0]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());


        $validation = $this->generateValidationItem(['firstname' => 6]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }

    public function testMinMax()
    {
        $validator = new IntegerValue(2, 5);

        $validation = $this->generateValidationItem(['firstname' => 5]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => 2]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => 3]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());



        $validation = $this->generateValidationItem(['firstname' => 6]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => 1]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());



        $validator = new IntegerValue(2, 2);

        $validation = $this->generateValidationItem(['firstname' => 2]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => 3]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }
}
