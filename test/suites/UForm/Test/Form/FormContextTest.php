<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form;

use UForm\Form;
use UForm\Form\Element\Primary\Input\Password;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator\DirectClosure;

/**
 * @covers UForm\Form\FormContext
 */
class FormContextTest extends \PHPUnit_Framework_TestCase
{
    protected $dataSet;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var Form\Element
     */
    protected $element;

    /**
     * @var Form\FormContext
     */
    protected $formContext;

    protected $localData;

    public function setUp()
    {

        $this->dataSet = [

            "lastname" => "simpson",
            "firstname"=> "homer",

            "age" => "40",

            "children" => [

                [
                    "lastname" => "simpson",
                    "firstname"=> "bart",
                    "age" => "12",
                    "dog" => [
                        "name" => "Santa's Little Helper"
                    ]
                ],

                [
                    "lastname" => "simpson",
                    "firstname"=> "lisa",
                    "age" => "10"
                ]
            ]

        ];

        $this->element = new Text("firstname");
        $this->element->addValidator(new DirectClosure(function (ValidationItem $v) {
            $message = new Message("invalid");
            $v->appendMessage($message);
            $v->setInvalid();
        }));

        $this->form = new Form();
        $this->form->addElement($this->element);
        $this->formContext = $this->form->generateContext($this->dataSet);
    }

    public function testGetChainedValidation()
    {
        $this->assertInstanceOf("UForm\Validation\ChainedValidation", $this->formContext->getChainedValidation());
    }

    public function testValidate()
    {
        $this->assertFalse($this->formContext->validate());
    }

    public function testGetForm()
    {
        $this->assertSame($this->form, $this->formContext->getForm());
    }

    public function testGetData()
    {
        $this->assertSame($this->dataSet, $this->formContext->getData()->getDataCopy());
    }

    public function testIsValid()
    {
        $this->assertTrue($this->formContext->isValid());
        $this->formContext->validate();
        $this->assertFalse($this->formContext->isValid());
    }

    public function testGetMessages()
    {
        $this->assertInstanceOf("UForm\Validation\Message\Group", $this->formContext->getMessages());
        $this->assertCount(0, $this->formContext->getMessages());
    }

    public function testElementIsValid()
    {
        $this->assertTrue($this->formContext->elementIsValid("firstname"));
    }

    public function testChildrenAreValid()
    {
        $this->assertTrue($this->formContext->childrenAreValid("firstname"));

        // test children are valid with deeper form structure
        $form = new Form();

        $userName = new Text("username");
        $userName->addValidator(function (ValidationItem $v) {
            if ($v->getValue() !== "bart") {
                $v->setInvalid();
            }
        });
        $password = new Password("password");
        $group = new Form\Element\Container\Group("user");
        $group->addElement($userName);
        $group->addElement($password);
        $form->addElement($group);

        $formContext = $form->validate(["user" => ["username" => "bart"]]);
        $this->assertTrue($formContext->childrenAreValid("user"));

        $formContext = $form->generateContext(["user" => ["username" => "lisa"]]);
        $this->assertTrue($formContext->childrenAreValid("user"));

        $formContext->validate(["user" => ["username" => "lisa"]]);
        $this->assertFalse($formContext->childrenAreValid("user"));

    }

    public function testGetValueFor()
    {
        $this->assertEquals("homer", $this->formContext->getValueFor("firstname"));
        $this->assertEquals("simpson", $this->formContext->getValueFor("lastname"));
    }
}
