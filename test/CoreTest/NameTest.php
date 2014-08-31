<?php

/**
 * CommonTest
 *
 * @author sghzal
 */
class NameTest extends PHPUnit_Framework_TestCase
{

    /**
     * @group names
     */
    public function testName(){
        
        $f = new UForm\Forms\Form();
        
        $e1 = new \UForm\Forms\Element\Text("e1");
        $e2 = new \UForm\Forms\Element\Text("e2");
        $e3 = new \UForm\Forms\Element\Text("e3");
        
        
        $g1 = new \UForm\Forms\Element\Group("g1");
        $g1e1 = new \UForm\Forms\Element\Text("e1");
        $g1e2 = new \UForm\Forms\Element\Text("e2");
        
        
        $g2 = new \UForm\Forms\Element\Group("");
        $g2e1 = new \UForm\Forms\Element\Text("g2e1");
        $g2e2 = new \UForm\Forms\Element\Text("g2e2");
        

        $f->addElement($e1);
        $f->addElement($e2);
        $f->addElement($e3);
        
        $g1->addElement($g1e1);
        $g1->addElement($g1e2);
        
        $this->assertEquals($e1,$f->getElement("e1"));
        $this->assertEquals($e2,$f->getElement("e2"));
        $this->assertEquals($e3,$f->getElement("e3"));
        
        
        $f->addElement($g1);
        
        $this->assertEquals($g1, $f->getElement("g1"));
        $this->assertEquals($g1e1, $f->getElement("g1.e1"));
        $this->assertEquals($g1e2, $f->getElement("g1.e2"));

        $g2->addElement($g2e1);
        $g1->addElement($g2);
        $this->assertEquals($g2e1 , $f->getElement("g1.g2e1"));
        
        $g2->addElement($g2e2);
        $this->assertEquals($g2e2 , $f->getElement("g1.g2e2"));
        $this->assertEquals($g2e2 , $g1->getElement("g2e2"));
        $this->assertEquals($g2e2 , $g2->getElement("g2e2"));
    }
    
    
}