<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Scenario;

use UForm\Builder;

/**
 * @codeCoverageIgnore
 */
class FormWithRadioTest extends \PHPUnit_Framework_TestCase
{


    public function testFormWithRadio()
    {

        $form = Builder::init()
            ->radioGroup("choose", "foo")
                ->radio("choose", "foo")
                ->radio("choose", "bar")
                ->radio("choose", "baz")
            ->close()
            ->getForm();


        $formContext = $form->validate([]);

        $this->assertSame(["choose" => "foo"], $formContext->getData()->getDataCopy());

    }
}
