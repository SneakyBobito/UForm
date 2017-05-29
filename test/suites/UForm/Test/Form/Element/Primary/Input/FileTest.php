<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary\Input;

use UForm\FileUpload;
use UForm\Form;
use UForm\Form\Element\Primary\Input;
use UForm\Form\Element\Primary\Input\File;
use UForm\Validator\IsValid;
use UForm\Validator\Required;

/**
 * @covers UForm\Form\Element\Primary\Input\File
 */
class FileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Input
     */
    protected $input;

    public function setUp()
    {
        $this->input = new File('inputname');
    }

    public function testConstruct()
    {
        $this->assertTrue($this->input->hasSemanticType('input:file'));
    }

    public function testRender()
    {
        $this->input = new File('inputname');
        $id = $this->input->getId();
        $render = $this->input->render([], []);

        $expected = '<input type="file" name="inputname" id="' . $id . '"/>';
        $this->assertEquals($expected, $render);


        // Render multiple / accept

        $this->input = new File('inputname', true, 'image/*');
        $id = $this->input->getId();
        $render = $this->input->render([], []);

        $expected = '<input type="file" name="inputname[]" id="' . $id . '" multiple accept="image/*"/>';
        $this->assertEquals($expected, $render);


        // Render with a FileUpload Value (object to string conversion issue)
        $this->input = new File('inputname', true, 'image/*');
        $id = $this->input->getId();
        $file = new FileUpload('foo.txt', '/tmp/foo.txt', UPLOAD_ERR_OK);
        $render = $this->input->render(['inputname' => $file], []);

        $expected = '<input type="file" name="inputname[]" id="' . $id . '" multiple accept="image/*"/>';
        $this->assertEquals($expected, $render);
    }


    public function testFormEnctype()
    {
        $form = new Form();
        $this->assertNull($form->getEnctype());
        $form->addElement($this->input);
        $this->assertEquals(Form::ENCTYPE_MULTIPART_FORMDATA, $form->getEnctype());
    }

    public function testIsDefined()
    {

        $form = new Form();
        $form->addElement($this->input);
        $this->input->addValidator(new IsValid());

        $this->assertTrue($form->validate([])->isValid());
        $this->assertTrue($form->validate(['inputname' => null])->isValid());
        $this->assertFalse($form->validate(['inputname' => 'sometext'])->isValid());
        $this->input->addValidator(new Required());
        $this->assertFalse($form->validate(['inputname' => null])->isValid());
    }
}
