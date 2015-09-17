<?php
/**
 * @license see LICENSE
 */

class FormDataProcessingTest extends PHPUnit_Framework_TestCase {


    public function testSimpleFormDataValidation()
    {
        $form = new \UForm\Form();

        $userName = new \UForm\Form\Element\Primary\Text("username");
        $userName->addFilter(new \UForm\Filter\Trim());
        $userName->addValidator(new \UForm\Validator\Particle\RuleBridge(new \Particle\Validator\Rule\LengthBetween(2, 5)));

        $password = new \UForm\Form\Element\Primary\Password("password");
        $password->addFilter(new \UForm\Filter\Trim());
        $password->addValidator(new \UForm\Validator\Particle\RuleBridge(new \Particle\Validator\Rule\LengthBetween(8, 10)));

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
        $this->assertSame($expected, $context->getData()->getArrayCopy());
        $this->assertTrue($context->isValid());


        // TEST 2
        $context = $form->validate([
            "username" => "gsouf              ",
            "password" => "verylongpassword "
        ]);
        $expected = [
            "username" => "gsouf",
            "password" => "verylongpassword"
        ];

        $this->assertSame($expected, $context->getData()->getArrayCopy());
        $this->assertFalse($context->isValid());

    }
}
