<?php

/**
 * CommonTest
 *
 * @author sghzal
 */
class ValidationTest extends PHPUnit_Framework_TestCase
{

    public function testRequired(){
        
        $f = new UForm\Forms\Form();
        
        $elm = new UForm\Forms\Element\Text("foo");
        $elm->addValidator(new \UForm\Validation\Validator\Required(array(
            "message"=>"field required"
        )));
       
        $f->add($elm);
     
        // CASE IS PRESENT
        $f->setData(array(
            "foo" => "oof"
        ));
        $f->validate();
        $this->assertTrue($f->isValid());
        
        
        
        // CASE IS PRESENT BUT EMPTY
        $f->setData(array(
            "foo" => ""
        ));
        $f->validate();
        $this->assertFalse($f->isValid());
        
        
        
        // CASE IS NOT PRESENT
        $f->setData(array(
            "bar" => "foo"
        ));
        $f->validate();
        $messages = $f->getElementMessages("foo");
        $this->assertFalse($f->isValid());
        $this->assertEquals(1,count($messages));
        $this->assertEquals("field required",$messages[0]);
    }
    
    
    
    
}
