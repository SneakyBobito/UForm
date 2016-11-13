<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Select;

use UForm\Form\Element\Primary\Select;
use UForm\Form\Element\Primary\Select\AbstractOption;

class AbstractOptionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractOption
     */
    protected $abstractOption;

    public function setUp()
    {
        $this->abstractOption = $this->getMockForAbstractClass(
            'UForm\Form\Element\Primary\Select\AbstractOption',
            ['optionName']
        );
    }


    public function testGetLabel()
    {
        $this->assertSame('optionName', $this->abstractOption->getLabel());
    }

    public function testSetSelect()
    {
        $select = new Select('select');
        $this->abstractOption->setSelect($select);
        $this->assertSame($select, $this->abstractOption->getSelect());
    }

    public function testGetSelect()
    {
        $this->assertNull($this->abstractOption->getSelect());
    }
}
