<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\DataContext;
use UForm\Form;
use UForm\Form\Element\Primary\Password;
use UForm\Form\Element\Primary\Text;
use UForm\Validation\Message;
use UForm\ValidationItem;
use UForm\Validator\DirectClosure;

class ValidationItemTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ValidationItem
     */
    protected $validationItem;

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
            return false;
        }));

        $this->form = new Form();
        $this->form->addElement($this->element);
        $this->formContext = $this->form->generateContext($this->dataSet);

        $this->localData = $this->formContext->getData()->findValue("children.0");

        $this->validationItem = new ValidationItem(
            new DataContext($this->localData),
            $this->element,
            $this->formContext
        );
    }

    public function testGetLocalData()
    {
        $this->assertSame($this->dataSet["children"][0], $this->validationItem->getLocalData()->getDataCopy());
    }

    public function testGetLocalName()
    {
        $this->assertSame("firstname", $this->validationItem->getLocalName());
    }

    public function testGetElement()
    {
        $this->assertSame($this->element, $this->validationItem->getElement());
    }

    public function testGetChainedValidation()
    {
        $this->assertInstanceOf("UForm\Validation\ChainedValidation", $this->validationItem->getChainedValidation());
    }

    public function testResetValidation()
    {
        $this->validationItem->validate();
        $this->assertFalse($this->validationItem->isValid());
        $this->validationItem->resetValidation();
        $this->assertTrue($this->validationItem->isValid());
    }

    public function testValidate()
    {
        $this->assertFalse($this->validationItem->validate());
    }

    public function testIsValid()
    {
        $this->assertTrue($this->validationItem->isValid());
    }

    public function testGetMessages()
    {
        $this->assertInstanceOf("UForm\Validation\Message\Group", $this->validationItem->getMessages());
        $this->assertCount(0, $this->validationItem->getMessages());
        $this->validationItem->validate();
        $this->assertInstanceOf("UForm\Validation\Message\Group", $this->validationItem->getMessages());
        $this->assertCount(1, $this->validationItem->getMessages());
    }

    public function testAppendMessage()
    {
        $message = new Message("message");
        $this->validationItem->appendMessage($message);
        $this->assertCount(1, $this->validationItem->getMessages());
        $this->assertSame($message, $this->validationItem->getMessages()->getAt(0));
    }

    public function testGetValue()
    {
        $this->assertEquals("bart", $this->validationItem->getValue());
    }

    public function testChildrenAreValid()
    {
        $this->assertTrue($this->validationItem->childrenAreValid());
        $this->validationItem->validate();
        $this->assertTrue($this->validationItem->childrenAreValid());


        // test children are valid with deeper form structure
        $form = new Form();

        $userName = new Text("username");
        $userName->addValidator(function (ValidationItem $v) {
            return $v->getValue() == "bart";

        });
        $password = new Password("password");
        $group = new Form\Element\Container\Group("user");
        $group->addElement($userName);
        $group->addElement($password);
        $form->addElement($group);

        $formContext = $form->validate(["user" => ["username" => "bart"]]);
        $validationItem = $formContext->getChainedValidation()->getValidation("user");
        $this->assertTrue($validationItem->childrenAreValid());

        $formContext = $form->validate(["user" => ["username" => "lisa"]]);
        $validationItem = $formContext->getChainedValidation()->getValidation("user");
        $this->assertFalse($validationItem->childrenAreValid());

    }

    public function testFindValue()
    {
        $this->assertEquals("homer", $this->validationItem->findValue("firstname"));
        $this->assertEquals("lisa", $this->validationItem->findValue("children.1.firstname"));
    }

    public function testFindLocalValue()
    {
        $this->assertEquals("bart", $this->validationItem->findLocalValue("firstname"));
        $this->assertEquals("Santa's Little Helper", $this->validationItem->findLocalValue("dog.name"));
    }
}
