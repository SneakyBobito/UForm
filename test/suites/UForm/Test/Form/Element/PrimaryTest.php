<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element;

class PrimaryTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $primaryElement = $this->getMockForAbstractClass("UForm\Form\Element\Primary", ["primaryElement"]);
        $this->assertTrue($primaryElement->hasSemanticType("primary"));
    }
}
