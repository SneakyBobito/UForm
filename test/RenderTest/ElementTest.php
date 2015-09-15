<?php

/**
 * CommonTest
 *
 * @author sghzal
 */
class RenderTest extends PHPUnit_Framework_TestCase
{
    public function testRender(){
        
        $f = new UForm\Forms\Form();
        $f->setAction("/blabla");
        $f->setMethod("POST");

        $f->addElement(new \UForm\Forms\Element\Text("a"));

        $f->addClass("blaclass");

        $render = new \UForm\Render\StandardHtmlRender();

        $f = new \UForm\Forms\FormContext($f);

        //var_dump($render->render($f));

    }
}
