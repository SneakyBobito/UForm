<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container;

use UForm\Form;
use UForm\Form\Element\Container\Collection;
use UForm\Form\Element\Primary\Input\Text;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Collection
     */
    protected $collection;

    protected $elementModel;

    public function setUp()
    {
        $this->elementModel =  new Text("firstname");
        $this->collection = new Collection("simpsons", $this->elementModel);
    }

    public function testCollection()
    {
        $this->assertSame($this->elementModel, $this->collection->getElement(""));
    }

    public function testPrepareValidation()
    {

        $form = new Form();
        $form->addElement($this->collection);
        $context = $form->generateContext(
            [
                "simpsons" => [
                    ["firstname" => "bart"],
                    ["firstname" => "lisa"]
                ]
            ]
        );

        $this->collection->prepareValidation($context->getData(), $context);
        $chainedValidation = $context->getChainedValidation();
        $validations = $chainedValidation->getValidations();

        $this->assertCount(4, $validations);

        $this->assertInstanceOf(
            "UForm\Form\Element\Primary\Input\Text",
            $chainedValidation->getValidation("simpsons.0")->getElement()
        );
        $this->assertInstanceOf(
            "UForm\Form\Element\Primary\Input\Text",
            $chainedValidation->getValidation("simpsons.1")->getElement()
        );

    }

    public function testGetElements()
    {
        $elements = $this->collection->getElements([
            "simpsons" => [
                ["firstname" => "bart"],
                ["firstname" => "lisa"],
                ["firstname" => "homer"],
                ["firstname" => "marge"]
            ]
        ]);

        $this->assertCount(4, $elements);

        foreach ($elements as $element) {
            $this->assertInstanceOf("UForm\Form\Element\Primary\Input\Text", $element);
        }

        $this->assertEquals("0", $elements[0]->getName());
        $this->assertEquals("1", $elements[1]->getName());
        $this->assertEquals("2", $elements[2]->getName());
        $this->assertEquals("3", $elements[3]->getName());
    }
}
