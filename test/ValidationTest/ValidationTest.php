<?php

/**
 * CommonTest
 *
 * @author sghzal
 */
class ValidationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @group validation
     */
    public function testRequired(){
        
        $f = new UForm\Forms\Form();
        
        $elm = new UForm\Forms\Element\Text("foo");
        $elm->addValidator(new \UForm\Validation\Validator\Required(array(
            "message"=>"field required"
        )));
       
        $f->addElement($elm);
     
        // CASE IS PRESENT
        $f->setData(array(
            "foo" => "oof"
        ));
        $f->validate();
        $this->assertTrue($f->formIsValid());
        
        
        
        // CASE IS PRESENT BUT EMPTY
        $f->setData(array(
            
        ));
        $f->validate();
        $this->assertFalse($f->formIsValid());
        
        
        
        // CASE IS NOT PRESENT
        $f->setData(array(
            "bar" => "foo"
        ));
        $f->validate();
        $messages = $f->getElementMessages("foo");
        $this->assertFalse($f->formIsValid());
        $this->assertEquals(1,count($messages));
        $this->assertEquals("field required",$messages[0]);
    }
    
    
    public function testAddMessageToOtherElement(){
        
        $f = new UForm\Forms\Form();
        
        $elm = new UForm\Forms\Element\Text("foo");
        $elm->addValidator(new \UForm\Validation\DirectValidator(function($v){
            $v->appendMessage("hey bar","bar");
            $v->appendMessage("im foo");
        }));
        $f->add($elm);
        
        $elm = new UForm\Forms\Element\Text("bar");
        $f->add($elm);
        
        $f->setData(array("foo"=>"aa"));
        $f->validate();
        
        $fooMessages = $f->getElementMessages("foo");
        $barMessages = $f->getElementMessages("bar");
        
        $this->assertEquals("hey bar",$barMessages[0]);
        $this->assertEquals("im foo",$fooMessages[0]);
        
    }
    
    
    public function testSameAs(){
        
        $f = new UForm\Forms\Form();
        
        $elm = new UForm\Forms\Element\Text("foo");
        $elm->addValidator(new \UForm\Validation\Validator\SameAs("bar",array(
            "message"=>"Foo is not same as bar"
        )));
        $f->add($elm);
        
        $elm = new UForm\Forms\Element\Text("bar");

        $f->add($elm);
        
        // CASE SAME
        $f->setData(array(
            "foo" => "oof",
            "bar" => "oof"
        ));
        $f->validate();
        $this->assertTrue($f->formIsValid());
        
        
        
        // CASE ONE IS MISSING
        $f->setData(array(
            "foo" => "oof",
        ));
        $f->validate();
        $this->assertFalse($f->formIsValid());
    }
    
    
    
    
}
