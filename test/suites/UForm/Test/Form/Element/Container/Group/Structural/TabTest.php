<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group\Structural;

use UForm\Form\Element\Container\Group\Structural\Tab;

class TabTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $group = new Tab('myTitle');

        $this->assertEquals('myTitle', $group->getOption('title'));
        $this->assertTrue($group->hasSemanticType('tab'));
    }
}
