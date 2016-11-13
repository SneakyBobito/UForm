<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Scenario;

use UForm\Builder;
use UForm\Validator\InRange;

/**
 * @codeCoverageIgnore
 */
class FormWithRadioTest extends \PHPUnit_Framework_TestCase
{


    public function testFormWithRadio()
    {

        $form = Builder::init()
            ->radioGroup('choose', 'foo')
                ->radio('choose', 'foo')
                ->radio('choose', 'bar')
                ->radio('choose', 'baz')
            ->close()
            ->getForm();


        // No data (should take the default "foo")
        $formContext = $form->validate([]);
        $this->assertSame(['choose' => 'foo'], $formContext->getData()->getDataCopy());
        $this->assertTrue($formContext->isValid());


        // Data set (should not set the default value)
        $formContext = $form->validate(['choose' => 'bar']);
        $this->assertSame(['choose' => 'bar'], $formContext->getData()->getDataCopy());
        $this->assertTrue($formContext->isValid());


        // Data not in value range
        $formContext = $form->validate(['choose' => 'fake']);
        $this->assertSame(['choose' => 'fake'], $formContext->getData()->getDataCopy());
        $this->assertFalse($formContext->isValid());
        $this->assertCount(1, $formContext->getMessages());
        $this->assertEquals(InRange::NOT_IN_RANGE, $formContext->getMessages()->getAt(0)->getType());
    }
}
