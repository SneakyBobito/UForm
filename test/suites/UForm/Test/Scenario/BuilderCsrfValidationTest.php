<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Scenario;

use UForm\Builder;
use UForm\Environment;
use UForm\Validator\Csrf;

/**
 * @codeCoverageIgnore
 */
class BuilderCsrfValidationTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        Environment::reset();
    }
    public function tearDown()
    {
        Environment::reset();
    }

    public function testCsrfBuilder()
    {

        $token = 'someToken';

        $csrfInterfaceStub = $this->getMock('UForm\Validator\Csrf\CsrfInterface');
        $csrfInterfaceStub->method('getToken')->willReturn($token);
        $csrfInterfaceStub->method('tokenIsValid')->willReturnCallback(function ($testedToken) use ($token) {
            return $token == $testedToken;
        });
        Environment::setCsrfResolver($csrfInterfaceStub);
        $form = Builder::init(null, null, ['csrf-name' => 'csrf'])->getForm();

        $context = $form->validate(['csrf' => 'fake']);
        $formValidation = $context->getChainedValidation()->getValidation($form->getInternalName(true), true);
        $this->assertFalse($context->isValid());
        $this->assertCount(1, $formValidation->getMessages());
        $this->assertCount(1, $context->getMessages());
        $this->assertEquals(Csrf::NOT_VALID, $formValidation->getMessages()->getAt(0)->getType());


        $context = $form->validate(['csrf' => $token]);
        $formValidation = $context->getChainedValidation()->getValidation($form->getInternalName(true), true);
        $this->assertCount(0, $formValidation->getMessages());
        $this->assertTrue($context->isValid());
    }
}
