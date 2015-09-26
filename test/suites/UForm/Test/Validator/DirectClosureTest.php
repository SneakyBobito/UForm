<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\ValidationItem;
use UForm\Validator\DirectClosure;

class DirectClosureTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validation = $this->generateValidationItem(["firstname" => "bart", "lastname" => "bart"]);
        $validator = new DirectClosure(function (ValidationItem $validationItem) {
            return $validationItem->getValue() == "bart";
        });
        $this->assertTrue($validator->validate($validation));
    }

    public function testNotValid()
    {
        $validation = $this->generateValidationItem(["firstname" => "foo", "lastname" => "bart"]);
        $validator = new DirectClosure(function (ValidationItem $validationItem) {
            return $validationItem->getValue() == "bart";
        });
        $this->assertFalse($validator->validate($validation));
    }
}
