<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Validation;

use UForm\DataContext;
use UForm\Form;
use UForm\Validation\ChainedValidation;
use UForm\Validation\Message;
use UForm\Validation\ValidationItem;
use UForm\Validator\DirectClosure;

/**
 * @covers UForm\Validation\ChainedValidation
 */
class ChainedValidationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ChainedValidation
     */
    protected $chainedValidation;

    protected $dataSet;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var Form\Element
     */
    protected $firstName;

    /**
     * @var Form\FormContext
     */
    protected $formContext;

    public function setUp()
    {

        $this->dataSet = [

            'lastname' => 'simpson',
            'firstname'=> 'homer',

            'age' => '40',

            'children' => [

                [
                    'lastname' => 'simpson',
                    'firstname'=> 'bart',
                    'age' => '12',
                    'dog' => [
                        'name' => "Santa's Little Helper"
                    ]
                ],

                [
                    'lastname' => 'simpson',
                    'firstname'=> 'lisa',
                    'age' => '10'
                ]
            ]

        ];

        $this->firstName = new Form\Element\Primary\Input\Text('firstname');
        $this->firstName->addValidator(new DirectClosure(function (ValidationItem $v) {
            $message = new Message('invalid');
            $v->appendMessage($message);
            $v->setInvalid();
        }));

        $this->form = new Form();
        $this->form->addElement($this->firstName);
        $this->formContext = $this->form->generateContext($this->dataSet);


        $this->chainedValidation = $this->formContext->getChainedValidation();
    }

    public function testAddValidation()
    {
        $chainedValidation = new ChainedValidation(new DataContext([]));
        $this->assertCount(0, $chainedValidation->getValidations());

        $validationItem = $this->chainedValidation->getValidationByName('firstname');
        $chainedValidation->addValidation($validationItem);

        $this->assertCount(1, $chainedValidation->getValidations());
        $this->assertSame($validationItem, $chainedValidation->getValidations()[0]);


        // Element with a name (int)0 (was causing issue because 0 was considered as null)
        $element = new Form\Element\Primary\Input\Text(0);
        $validationItem = new ValidationItem(new DataContext([]), $element, $this->formContext);
        $chainedValidation->addValidation($validationItem);
        $this->assertCount(2, $chainedValidation->getValidations());
        $this->assertSame($chainedValidation->getValidation(0), $chainedValidation->getValidations()[1]);
    }

    public function testGetDataFor()
    {
        $data = $this->chainedValidation->getDataFor($this->firstName);
        $this->assertEquals('homer', $data);

        $data = $this->chainedValidation->getDataFor('firstname');
        $this->assertEquals('homer', $data);

        $chainedValidation = new ChainedValidation(new DataContext(null));
        $this->assertNull($chainedValidation->getDataFor('firstname'));
    }

    public function testGetValidation()
    {

        $validation = $this->chainedValidation->getValidation($this->firstName);
        $this->assertEquals($this->firstName, $validation->getElement());

        $validation = $this->chainedValidation->getValidation($this->firstName->getInternalName(true), true);
        $this->assertEquals($this->firstName, $validation->getElement());

        $this->assertNull($this->chainedValidation->getValidation('fake'));

        $this->setExpectedException('UForm\InvalidArgumentException');
        $this->chainedValidation->getValidation([]);
    }

    public function testGetValidations()
    {
        $this->assertInternalType('array', $this->chainedValidation->getValidations());
        $this->assertCount(2, $this->chainedValidation->getValidations());
    }

    public function testGetValidationByName()
    {
        $this->assertSame(
            'firstname',
            $this->chainedValidation->getValidationByName('firstname')->getElement()->getName()
        );
    }

    public function testGetData()
    {
        $this->assertSame($this->dataSet, $this->chainedValidation->getData()->getDataCopy());
    }

    public function testValidate()
    {
        $isValid = $this->chainedValidation->validate();
        $this->assertFalse($isValid);
    }

    public function isValid()
    {
        $this->assertTrue($this->chainedValidation->isValid());
        $this->chainedValidation->validate();
        $this->assertFalse($this->chainedValidation->isValid());
    }

    public function testElementIsValid()
    {
        $this->assertTrue($this->chainedValidation->elementIsValid('firstname'));
        $this->chainedValidation->validate();
        $this->assertFalse($this->chainedValidation->elementIsValid('firstname'));

        $this->setExpectedException('UForm\Exception');
        $this->chainedValidation->elementIsValid('fake');
    }

    public function testElementChildrenAreValid()
    {

        $this->assertTrue($this->chainedValidation->elementChildrenAreValid($this->firstName));
        $this->chainedValidation->validate();
        $this->assertTrue($this->chainedValidation->elementChildrenAreValid($this->firstName));

        $this->setExpectedException('UForm\Exception');
        $this->chainedValidation->elementChildrenAreValid('fake');
    }
}
