<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\Form;
use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\File;

class FileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new File("inputname");
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType("input:file"));
    }

    public function testRender()
    {
        $this->input = new File("inputname");
        $id = $this->input->getId();
        $render = $this->input->render([], []);

        $expected = '<input type="file" name="inputname" id="' . $id . '"/>';
        $this->assertEquals($expected, $render);
    }

    public function testFOrmEnctype()
    {
        $form = new Form();
        $this->assertNull($form->getEnctype());
        $form->addElement($this->input);
        $this->assertEquals(Form::ENCTYPE_MULTIPART_FORMDATA, $form->getEnctype());
    }
}
