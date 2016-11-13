<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\Environment;
use UForm\Validation\Message\DefaultTranslator;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        Environment::reset();
    }

    public function setUp()
    {
        Environment::reset();
    }

    public function testSetEnvironment()
    {
        $translator = new DefaultTranslator();
        Environment::setMessageTranslator($translator);
        $this->assertSame($translator, Environment::getTranslator());
    }

    public function testGetEnvironment()
    {
        $translator = Environment::getTranslator();
        $this->assertInstanceOf('UForm\Validation\Message\TranslationInterface', $translator);
    }

    public function testReset()
    {
        $translator = new DefaultTranslator();
        Environment::setMessageTranslator($translator);
        $this->assertSame($translator, Environment::getTranslator());
        Environment::reset();
        $this->assertNotSame($translator, Environment::getTranslator());
    }
}
