<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validator;

use UForm\Test\ValidatorTestCase;
use UForm\Validator\Json;

class JsonTest extends ValidatorTestCase
{

    public function testValid()
    {
        $validator = new Json();

        $validation = $this->generateValidationItem(['firstname' => '"bart"']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        $validation = $this->generateValidationItem(['firstname' => '{}']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());
    }

    public function testInvalid()
    {
        $validator = new Json();
        $validation = $this->generateValidationItem(['firstname' => 'bart']);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(Json::INVALID_JSON_STRING, $message->getType());

        $validation = $this->generateValidationItem(['firstname' => '{']);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $message =  $validation->getMessages()->getAt(0);
        $this->assertSame(Json::INVALID_JSON_STRING, $message->getType());
    }
}
