<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Filter\BooleanValue;
use UForm\Filter\BoolToInt;
use UForm\Filter\DefaultValue;
use UForm\Form;
use UForm\Form\Element\Primary\Input\Check;
use UForm\Render\RenderContext;

/**
 * @covers \UForm\Form\Element\Primary\Input\Check
 */
class CheckTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $input = new Check('inputname');
        $this->assertTrue($input->hasSemanticType('input:checkbox'));
    }

    public function testRender()
    {
        $input = new Check('inputname');
        $id = $input->getId();
        $render = $input->render(['inputname' => true]);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1" checked="checked"/>';
        $this->assertEquals($expected, $render);

        // false value
        $input = new Check('inputname');
        $id = $input->getId();
        $render = $input->render(['inputname' => false]);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1"/>';
        $this->assertEquals($expected, $render);

        // No value
        $input = new Check('inputname');
        $id = $input->getId();
        $render = $input->render([]);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1"/>';
        $this->assertEquals($expected, $render);
    }



    public function testRenderWithContext()
    {

        $input = new Check('inputname', true);
        $input->addFilter($input);

        $form = new Form();
        $form->addElement($input);


        $context = $form->generateContext([]);
        $id = $input->getId();
        $render = $input->render(['inputname' => true], []);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1" checked="checked"/>';
        $this->assertEquals($expected, $render);


        $context = $form->generateContext(['inputname' => 1]);
        $id = $input->getId();
        $render = $input->render(['inputname' => true], []);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1" checked="checked"/>';
        $this->assertEquals($expected, $render);
    }

    public function testRenderWithSubmittedContext()
    {

        $input = new Check('inputname');
        $input->addFilter($input);

        $form = new Form();
        $form->addElement($input);


        $context = $form->generateContext([], true);
        $id = $input->getId();
        $render = $input->render($context->getData()->getDataCopy(), [], $context);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1"/>';
        $this->assertEquals($expected, $render);


        $context = $form->generateContext(['inputname' => 1], true);
        $id = $input->getId();
        $render = $input->render($context->getData()->getDataCopy(), [], $context);
        $expected = '<input type="checkbox" name="inputname" id="' . $id . '" value="1" checked="checked"/>';
        $this->assertEquals($expected, $render);
    }
}
