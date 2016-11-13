<?php

namespace UForm\Test;

use UForm\Validator\Required;
use UForm\Validator\StringLength;
use UForm\ValidatorGroup;

class ValidatorGroupTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ValidatorGroup
     */
    protected $validatorGroupStub;
    
    public function setup()
    {
        $this->validatorGroupStub = $this->getMockForTrait('UForm\ValidatorGroup');
    }

    public function testAddValidator()
    {
        $validator = new Required();
        $output = $this->validatorGroupStub->addValidator($validator);
        $this->assertSame($validator, $output);
        $this->assertSame([$validator], $this->validatorGroupStub->getValidators());

        $validator2 = new StringLength();
        $output = $this->validatorGroupStub->addValidator($validator2);
        $this->assertSame([$validator, $validator2], $this->validatorGroupStub->getValidators());
        $this->assertSame($validator2, $output);

        $this->setExpectedException('UForm\InvalidArgumentException');
        $this->validatorGroupStub->addValidator([]);
    }

    public function testAddValidators()
    {
        $validator = new Required();
        $this->validatorGroupStub->addValidator($validator);
        $this->assertSame([$validator], $this->validatorGroupStub->getValidators());

        $validator2 = new StringLength();
        $validator3 = new StringLength();
        $output = $this->validatorGroupStub->addValidators([$validator2, $validator3]);
        $this->assertSame([$validator, $validator2, $validator3], $this->validatorGroupStub->getValidators());
        $this->assertSame([$validator2, $validator3], $output);
    }

    public function testGetValidators()
    {
        $this->assertSame([], $this->validatorGroupStub->getValidators());
    }

    public function testSetValidators()
    {
        $validator = new Required();
        $this->validatorGroupStub->addValidator($validator);
        $this->assertSame([$validator], $this->validatorGroupStub->getValidators());

        $validator2 = new StringLength();
        $validator3 = new StringLength();
        $output = $this->validatorGroupStub->setValidators([$validator2, $validator3]);
        $this->assertSame([$validator2, $validator3], $this->validatorGroupStub->getValidators());
        $this->assertSame([$validator2, $validator3], $output);

        $output = $this->validatorGroupStub->setValidators(null);
        $this->assertSame([], $output);
        $this->assertSame([], $this->validatorGroupStub->getValidators());
    }
}
