<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\FileUpload;

/**
 * @covers UForm\FileUpload
 */
class FileUploadTest extends \PHPUnit_Framework_TestCase
{

    const UPDIR = __DIR__ . '/../../../Fixtures/file-upload';

    public function testFromGlobal()
    {
        $filesGlobal = [
            'foo' => [
                'name' => 'foo.txt',
                'tmp_name' => '/tmp/foo.txt',
                'error'    => UPLOAD_ERR_OK
            ],

            'bar' => [
                'name' => [
                    'bar1.txt',
                    'bar2.txt'
                ],
                'tmp_name' => [
                    '/tmp/bar1.txt',
                    '/tmp/bar2.txt'
                ],
                'error' => [
                    UPLOAD_ERR_OK,
                    UPLOAD_ERR_OK
                ]
            ],

            'nothing' => [
                'name' => '',
                'tmp_name' => '',
                'error'    => UPLOAD_ERR_NO_FILE
            ]
        ];

        $files = FileUpload::fromGlobalFilesVariable($filesGlobal, false);

        $this->assertCount(3, $files);
        $this->assertArrayHasKey('foo', $files);
        $this->assertArrayHasKey('bar', $files);
        $this->assertArrayHasKey('nothing', $files);

        $this->assertInstanceOf('UForm\FileUpload', $files['foo']);
        $this->assertInternalType('array', $files['bar']);
        $this->assertCount(2, $files['bar']);

        $this->assertNull($files['nothing']);
    }

    public function testGetPath()
    {
        $file = new FileUpload('foo.txt', '/tmp/foo.txt', UPLOAD_ERR_OK);
        $this->assertSame('/tmp/foo.txt', $file->getPath());
    }

    public function testGetName()
    {
        $file = new FileUpload('foo.txt', '/tmp/foo.txt', UPLOAD_ERR_OK);
        $this->assertSame('foo.txt', $file->getName());
    }

    public function testGetStatus()
    {
        $file = new FileUpload('foo.txt', '/tmp/foo.txt', UPLOAD_ERR_OK);
        $this->assertSame(UPLOAD_ERR_OK, $file->getStatus());
    }

    public function testHasError()
    {
        $file = new FileUpload('foo.txt', '/tmp/foo.txt', UPLOAD_ERR_OK);
        $this->assertFalse($file->hasError());

        $file = new FileUpload('foo.txt', '/tmp/foo.txt', UPLOAD_ERR_CANT_WRITE);
        $this->assertTrue($file->hasError());
    }

    public function testMoveTo()
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'uform_test');
        file_put_contents($tmpFile, 'uform_test_data');

        $file = new FileUpload('foo.txt', $tmpFile, UPLOAD_ERR_OK);

        $tmpFileDest = tempnam(sys_get_temp_dir(), 'uform_test');
        $file->moveTo($tmpFileDest);

        $this->assertFileExists($tmpFileDest);
        $this->assertEquals('uform_test_data', file_get_contents($tmpFileDest));

        $this->assertEquals($tmpFileDest, $file->getPath());
    }

    /**
     * @dataProvider mimTypeProvider
     */
    public function testMimeType($fileName, $mimeType)
    {
        $file = new FileUpload('foo.txt', self::UPDIR . $fileName, UPLOAD_ERR_OK);
        $this->assertEquals($mimeType, $file->getMimeType());
    }

    public function mimTypeProvider()
    {
        return [
            ['/foo.txt', 'text/plain'],
            ['/1px.gif', 'image/gif'],
            ['/1px.png', 'image/png'],
            ['/1px.jpg', 'image/jpeg'],
            ['/pdf-sample.pdf', 'application/pdf'],
        ];
    }
}
