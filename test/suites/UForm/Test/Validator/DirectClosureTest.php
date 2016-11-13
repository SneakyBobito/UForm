<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\Validation\ValidationItem;
use UForm\Validator\DirectClosure;

class DirectClosureTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validation = $this->generateValidationItem(['firstname' => 'bart', 'lastname' => 'bart']);
        $validator = new DirectClosure(function (ValidationItem $validationItem) {
            if ($validationItem->getValue() !== 'bart') {
                $validationItem->setInvalid();
            }
        });
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(['firstname' => 'foo', 'lastname' => 'bart']);
        $validator = new DirectClosure(function (ValidationItem $validationItem) {
            if ($validationItem->getValue() !== 'bart') {
                $validationItem->setInvalid();
            }
        });
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
    }
}
