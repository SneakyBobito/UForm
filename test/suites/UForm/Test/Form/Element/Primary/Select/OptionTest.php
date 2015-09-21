<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Select;

use UForm\Form\Element\Primary\Select\Option;

class OptionTest extends \PHPUnit_Framework_TestCase
{

    public function testOption()
    {
        $option = new Option("optionValue", "optionLabel");
        $this->assertEquals("optionValue", $option->getValue());
        $this->assertEquals("optionLabel", $option->getLabel());
    }
}
