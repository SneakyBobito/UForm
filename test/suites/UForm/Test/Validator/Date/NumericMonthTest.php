<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator\Date;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\Date\NumericMonth;

class NumericMonthTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validator = new NumericMonth();

        $validation = $this->generateValidationItem(['firstname' => 1]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => '12']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validator = new NumericMonth(true);

        $validation = $this->generateValidationItem(['firstname' => 0]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => '11']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testInvalid()
    {
        $validator = new NumericMonth();

        $validation = $this->generateValidationItem(['firstname' => '0']);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(NumericMonth::NOT_NUMERIC_MONTH, $message->getType());

        $validation = $this->generateValidationItem(['firstname' => 13]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(NumericMonth::NOT_NUMERIC_MONTH, $message->getType());


        $validator = new NumericMonth(true);

        $validation = $this->generateValidationItem(['firstname' => '-1']);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(NumericMonth::NOT_NUMERIC_MONTH, $message->getType());

        $validation = $this->generateValidationItem(['firstname' => 12]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(NumericMonth::NOT_NUMERIC_MONTH, $message->getType());
    }
}
