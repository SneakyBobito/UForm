<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container\Group;

use UForm\Form\Element\Container\Group\CheckGroup;

class CheckGroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CheckGroup
     */
    protected $checkGroup;

    public function testConstruct()
    {
        $checkgroup = new CheckGroup("checkGroup");
        $this->assertTrue($checkgroup->hasSemanticType("checkGroup"));
    }
}
