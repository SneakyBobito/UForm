<?php

namespace UForm\Test;

use UForm\SemanticItem;

class SemanticItemTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SemanticItem
     */
    protected $semanticItemStub;
    
    public function setup()
    {
        $this->semanticItemStub = $this->getMockForTrait('UForm\SemanticItem');
    }

    public function testAddSemanticType()
    {
        $this->semanticItemStub->addSemanticType('type1');
        $this->assertTrue($this->semanticItemStub->hasSemanticType('type1'));

        $this->semanticItemStub->addSemanticType('type2');
        $this->assertTrue($this->semanticItemStub->hasSemanticType('type1'));
        $this->assertTrue($this->semanticItemStub->hasSemanticType('type2'));
    }

    public function testHasSemanticType()
    {
        $this->assertFalse($this->semanticItemStub->hasSemanticType('type1'));
        $this->semanticItemStub->addSemanticType('type1');
        $this->assertTrue($this->semanticItemStub->hasSemanticType('type1'));
    }

    public function testGetSemanticTypes()
    {
        $this->assertSame([], $this->semanticItemStub->getSemanticTypes());
        $this->semanticItemStub->addSemanticType('type1');
        $this->semanticItemStub->addSemanticType('type2');
        // ORDER IS IMPORTANT
        $this->assertSame(['type2', 'type1'], $this->semanticItemStub->getSemanticTypes());
    }
}
