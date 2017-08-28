<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator\Date;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\Date\DayOfMonth;

class DayOfMonthTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validator = new DayOfMonth();

        $validation = $this->generateValidationItem(['firstname' => 1]);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => '31']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testInvalid()
    {
        $validator = new DayOfMonth();

        $validation = $this->generateValidationItem(['firstname' => '0']);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(DayOfMonth::NOT_DAY_OF_MONTH, $message->getType());

        $validation = $this->generateValidationItem(['firstname' => 32]);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(DayOfMonth::NOT_DAY_OF_MONTH, $message->getType());
    }
}
