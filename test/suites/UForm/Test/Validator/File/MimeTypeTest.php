<?php
/**
 * @license see LICENSE
 */


namespace UForm\Test\Validator\File;

use UForm\DataContext;
use UForm\FileUpload;
use UForm\Form;
use UForm\Form\Element\Primary\Input\File;
use UForm\Test\FileUploadTest;
use UForm\Test\ValidatorTestCase;
use UForm\Validation\ValidationItem;
use UForm\Validator\File\MimeType;

class MimeTypeTest extends ValidatorTestCase
{

    public function generateValidationItem($data, $multiple = false)
    {
        $firstname = new File('firstname', $multiple);

        $form = new Form();
        $form->addElement($firstname);
        $formContext = $form->generateContext($data);

        return new ValidationItem(
            new DataContext($data),
            $firstname,
            $formContext
        );
    }

    public function testMimeType()
    {

        $file = new FileUpload('foo.txt', FileUploadTest::UPDIR . '/foo.txt', UPLOAD_ERR_OK);

        // test good mime type
        $validation = $this->generateValidationItem(['firstname' => $file]);
        $validator = new MimeType(['text/plain']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        // Test mixed good and bad mime type
        $validation = $this->generateValidationItem(['firstname' => $file]);
        $validator = new MimeType(['text/plain', 'image/jpeg']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        // Test one bad mime type
        $validation = $this->generateValidationItem(['firstname' => $file]);
        $validator = new MimeType(['image/jpeg']);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $this->assertEquals(MimeType::INVALID_FILE_TYPE, $validation->getMessages()->getAt(0)->getType());

        // Test wild card
        $validation = $this->generateValidationItem(['firstname' => $file]);
        $validator = new MimeType(['text/*']);
        $validator->validate($validation);
        $this->assertTrue($validation->isValid());

        // Test not valid file
        $validation = $this->generateValidationItem(['firstname' => 'foo']);
        $validator = new MimeType(['text/plain']);
        $validator->validate($validation);
        $this->assertFalse($validation->isValid());
        $this->assertEquals(MimeType::NOT_A_FILE, $validation->getMessages()->getAt(0)->getType());
    }

    public function testValidateArray()
    {
        $file = new FileUpload('foo.txt', FileUploadTest::UPDIR . '/foo.txt', UPLOAD_ERR_OK);

        // Test array
        $validation = $this->generateValidationItem(['firstname' => [$file]], true);
        $validator = new MimeType(['text/*']);
        $validator->validate($validation);

        $this->assertTrue($validation->isValid());
    }
}
