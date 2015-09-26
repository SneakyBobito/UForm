<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Scenario;

use UForm\Form\Element\Primary\Input\Password;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Validator\StringLength;

class FormDataProcessingTest extends \PHPUnit_Framework_TestCase
{


    public function testSimpleFormDataValidation()
    {
        $form = new \UForm\Form();

        $userName = new Text("username");
        $userName->addFilter(new \UForm\Filter\Trim());
        $userName->addValidator(new StringLength(2, 5));

        $password = new Password("password");
        $password->addFilter(new \UForm\Filter\Trim());
        $password->addValidator(new StringLength(8, 10));

        $form->addElement($userName);
        $form->addElement($password);


        // TEST 1
        $context = $form->validate([
            "username" => "gsouf ",
            "password" => " password            "
        ]);
        $expected = [
            "username" => "gsouf",
            "password" => "password"
        ];
        $this->assertSame($expected, $context->getData()->getDataCopy());
        $this->assertTrue($context->isValid());
        $this->assertSame(0, count($context->getMessages()));


        // TEST 2
        $context = $form->validate([
            "username" => "gsouf              ",
            "password" => "verylongpassword "
        ]);
        $expected = [
            "username" => "gsouf",
            "password" => "verylongpassword"
        ];

        $this->assertSame($expected, $context->getData()->getDataCopy());
        $this->assertFalse($context->isValid());

        $messages = $context->getMessages();
        $this->assertEquals(1, count($messages));
        $this->assertSame(StringLength::TOO_LONG, $messages->getAt(0)->getType());

    }
}
