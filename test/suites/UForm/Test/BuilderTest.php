<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\Builder;

class BuilderTest extends \PHPUnit_Framework_TestCase
{

    public function testGetForm()
    {
        $builder =new Builder();
        $this->assertInstanceOf("UForm\Form", $builder->getForm());
    }
}
