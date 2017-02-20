<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Builder;

use UForm\Builder;
use UForm\Form\Element\Container\Group;
use UForm\Validator\Regexp;
use UForm\Validator\Required;

class ValidatorBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Builder
     */
    protected $validatorBuilder;


    public function setUp()
    {
        $this->validatorBuilder = new Builder();
    }

    public function testValidator()
    {
        $validator = new Required();
        $this->validatorBuilder->text('text');
        $this->validatorBuilder->validator($validator);

        $this->assertSame($validator, $this->validatorBuilder->last()->getValidators()[0]);
    }

    public function testRequired()
    {
        $this->validatorBuilder->text('text');
        $output = $this->validatorBuilder->required();

        $this->assertSame($this->validatorBuilder, $output);
        $this->assertInstanceOf('UForm\Validator\Required', $this->validatorBuilder->last()->getValidators()[0]);
    }

    public function testStringLength()
    {
        $this->validatorBuilder->text('text');
        $output = $this->validatorBuilder->stringLength(5, 10);

        $this->assertSame($this->validatorBuilder, $output);
        $this->assertInstanceOf('UForm\Validator\StringLength', $this->validatorBuilder->last()->getValidators()[0]);
    }

    public function testAlphaNum()
    {
        $this->validatorBuilder->text('text');
        $output = $this->validatorBuilder->alphaNum();

        $this->assertSame($this->validatorBuilder, $output);
        $this->assertInstanceOf('UForm\Validator\AlphaNum', $this->validatorBuilder->last()->getValidators()[0]);
    }

    public function testInRange()
    {
        $this->validatorBuilder->text('text');
        $output = $this->validatorBuilder->inRange(['bart', 'homer']);

        $this->assertSame($this->validatorBuilder, $output);
        $this->assertInstanceOf('UForm\Validator\InRange', $this->validatorBuilder->last()->getValidators()[0]);
    }

    public function testRegexp()
    {
        $this->validatorBuilder->text('text');
        $output = $this->validatorBuilder->regexp('/[a-z]+/');

        $this->assertSame($this->validatorBuilder, $output);
        $this->assertInstanceOf(Regexp::class, $this->validatorBuilder->last()->getValidators()[0]);
    }
}
