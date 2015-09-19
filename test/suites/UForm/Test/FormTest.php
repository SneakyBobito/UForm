<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\Filter\Trim;
use UForm\Form;
use UForm\ValidationItem;

class FormTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Form
     */
    protected $form;

    public function setUp()
    {
        $this->form = new Form();

        $userName = new Form\Element\Primary\Text("username");
        $userName->addValidator(function (ValidationItem $v) {
            return $v->getValue() == "bart";

        });
        $userName->addFilter(new Trim());
        $password = new Form\Element\Primary\Password("password");
        $group = new Form\Element\Container\Group("user");
        $group->addElement($userName);
        $group->addElement($password);

        $this->form->addElement($group);
    }


    public function testGetAction()
    {
        $form = new Form();
        $this->assertNull($form->getAction());

        $form = new Form("someAction");
        $this->assertEquals("someAction", $form->getAction());
    }

    public function testGetMethod()
    {
        $form = new Form();
        $this->assertEquals(Form::METHOD_POST, $form->getMethod());

        $form = new Form(null, "FancyMethod");
        $this->assertEquals("FancyMethod", $form->getMethod());
    }

    public function testSetAction()
    {
        $form = new Form();
        $form->setAction("action");
        $this->assertEquals("action", $form->getAction());
    }

    public function testSetMethod()
    {
        $form = new Form();
        $form->setMethod("method");
        $this->assertEquals("method", $form->getMethod());
    }

    public function testGenerateContext()
    {
        $context = $this->form->generateContext(["data" => "value"]);
        $this->assertInstanceOf("UForm\Form\FormContext", $context);
        $this->assertSame(["data" => "value"], $context->getData()->getDataCopy());
        $this->assertSame($this->form, $context->getForm());
        $this->assertTrue($context->isValid()); // Still valid because no validation was processed


        $context = $this->form->generateContext(["user" => ["username" => "bart ", "password" => "pass "]]);
        $this->assertInstanceOf("UForm\Form\FormContext", $context);
        $this->assertSame(
            ["user" => ["username" => "bart", "password" => "pass "]],
            $context->getData()->getDataCopy()
        );
        $this->assertTrue($context->isValid());
    }

    public function testValidate()
    {
        $context = $this->form->validate(["data" => "value"]);
        $this->assertInstanceOf("UForm\Form\FormContext", $context);
        $this->assertSame(["data" => "value"], $context->getData()->getDataCopy());
        $this->assertSame($this->form, $context->getForm());
        $this->assertFalse($context->isValid()); // Still valid because no validation was processed


        $context = $this->form->validate(["user" => ["username" => "bart ", "password" => "pass "]]);
        $this->assertInstanceOf("UForm\Form\FormContext", $context);
        $this->assertSame(
            ["user" => ["username" => "bart", "password" => "pass "]],
            $context->getData()->getDataCopy()
        );
        $this->assertTrue($context->isValid());
    }

    public function testBind()
    {

        $o = new \stdClass();
        $this->form->bind($o, [
            "user" => ["username" => "bart", "password" => "pass"],
            "username" => "homer"
        ]);
        $this->assertCount(1, (array)$o);
        $this->assertObjectHasAttribute("user", $o);
        $this->assertSame(["username" => "bart", "password" => "pass"], $o->user);

        $o = new \stdClass();
        $this->form->bind($o, [
            "user" => ["username" => "bart", "password" => "pass"],
            "username" => "homer"
        ], ["user"]);
        $this->assertCount(1, (array)$o);
        $this->assertObjectHasAttribute("user", $o);
        $this->assertSame(["username" => "bart", "password" => "pass"], $o->user);

        $o = new \stdClass();
        $this->form->bind($o, [
            "user" => ["username" => "bart", "password" => "pass"],
            "username" => "homer"
        ], ["username"]);
        $this->assertCount(0, (array)$o);

        $o = new \stdClass();
        $this->form->bind($o, [
            "user" => ["username" => "bart", "password" => "pass"],
            "username" => "homer"
        ], []);
        $this->assertCount(0, (array)$o);


    }
}
