<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Builder;

use UForm\Builder;
use UForm\Form;
use UForm\Form\Element\Container\Group;
use UForm\Form\Element\Primary\Input\Check;
use UForm\Form\Element\Primary\Input\File;
use UForm\Form\Element\Primary\Input\Submit;
use UForm\Validator\File\MimeType;

class InputBuilderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Builder
     */
    protected $inputBuilderStub;

    /**
     * @var Group
     */
    protected $parentGroup;

    public function setUp()
    {
        $this->inputBuilderStub = new Builder();
    }

    public function testText()
    {
        $this->inputBuilderStub->text('inputName', 'inputTitle');
        $this->assertInstanceOf(\UForm\Form\Element\Primary\Input\Text::class, $this->inputBuilderStub->last());
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
        $this->assertEquals('inputTitle', $this->inputBuilderStub->last()->getOption('label'));
    }

    public function testColor()
    {
        $this->inputBuilderStub->color('inputName', 'inputTitle');
        $this->assertInstanceOf(\UForm\Form\Element\Primary\Input\Color::class, $this->inputBuilderStub->last());
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
        $this->assertEquals('inputTitle', $this->inputBuilderStub->last()->getOption('label'));
    }

    public function testRange()
    {
        $this->inputBuilderStub->range('foobar', 'baz', null, 9, 22, 2);
        $this->assertInstanceOf(\UForm\Form\Element\Primary\Input\Range::class, $this->inputBuilderStub->last());
        $this->assertEquals('foobar', $this->inputBuilderStub->last()->getName());
        $this->assertEquals('baz', $this->inputBuilderStub->last()->getOption('label'));
        $this->assertEquals(9, $this->inputBuilderStub->last()->getAttribute('min'));
        $this->assertEquals(22, $this->inputBuilderStub->last()->getAttribute('max'));
        $this->assertEquals(2, $this->inputBuilderStub->last()->getAttribute('step'));
    }

    public function testTextArea()
    {
        $this->inputBuilderStub->textArea('inputName', 'inputTitle');
        $this->assertInstanceOf(\UForm\Form\Element\Primary\TextArea::class, $this->inputBuilderStub->last());
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
        $this->assertEquals('inputTitle', $this->inputBuilderStub->last()->getOption('label'));
    }

    public function testPassword()
    {
        $this->inputBuilderStub->password('inputName', 'inputTitle');
        $this->assertInstanceOf(\UForm\Form\Element\Primary\Input\Password::class, $this->inputBuilderStub->last());
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
        $this->assertEquals('inputTitle', $this->inputBuilderStub->last()->getOption('label'));
    }

    public function testSelect()
    {
        $this->inputBuilderStub->select('inputName', 'inputTitle');
        $this->assertInstanceOf(\UForm\Form\Element\Primary\Select::class, $this->inputBuilderStub->last());
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
        $this->assertEquals('inputTitle', $this->inputBuilderStub->last()->getOption('label'));
    }

    public function testSelectMultiple()
    {
        $this->inputBuilderStub->selectMultiple('inputName', 'inputTitle');
        /* @var Form\Element\Primary\Select $select */
        $select = $this->inputBuilderStub->last();
        $this->assertInstanceOf(\UForm\Form\Element\Primary\Select::class, $select);
        $this->assertTrue($select->isMultiple());
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
        $this->assertEquals('inputTitle', $this->inputBuilderStub->last()->getOption('label'));

        $form = $this->inputBuilderStub->getForm();

        $context = $form->generateContext();

        $inputValue = $context->getValueFor('inputName');

        $this->assertEquals([], $inputValue);
    }

    public function testHidden()
    {
        $this->inputBuilderStub->hidden('inputName', 'inputTitle');
        $this->assertInstanceOf(\UForm\Form\Element\Primary\Input\Hidden::class, $this->inputBuilderStub->last());
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
    }

    public function testFile()
    {
        $this->inputBuilderStub->file('inputName', 'inputTitle');
        $this->assertInstanceOf(File::class, $this->inputBuilderStub->last());
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
    }

    public function testCheck()
    {
        $this->inputBuilderStub->check('inputName', 'inputTitle');
        /* @var Check $check */
        $check = $this->inputBuilderStub->last();
        $this->assertInstanceOf(Check::class, $check);
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
    }

    public function testCheckLogic()
    {
        $this->inputBuilderStub->check('inputName', 'inputTitle', true);
        /* @var Check $check */
        $check = $this->inputBuilderStub->last();

        /* @var Form $form */
        $form = $this->inputBuilderStub->getForm();

        $data = [];
        $form->generateContext()->bind($data);
        $this->assertEquals(['inputName' => true], $data);

        $data = [];
        $form->generateContext(['inputName' => 0])->bind($data);
        $this->assertEquals(['inputName' => false], $data);

        $data = [];
        $form->generateContext(['inputName' => 1])->bind($data);
        $this->assertEquals(['inputName' => true], $data);


        // with submitted filter
        $data = [];
        $form->generateContext([], true)->bind($data);
        $this->assertEquals(['inputName' => false], $data);

        $data = [];
        $form->generateContext(['inputName' => 0], true)->bind($data);
        $this->assertEquals(['inputName' => false], $data);

        $data = [];
        $form->generateContext(['inputName' => 1], true)->bind($data);
        $this->assertEquals(['inputName' => true], $data);
    }

    public function testFileMimeType()
    {
        $this->inputBuilderStub->file('inputName', 'inputTitle', null, ['text/plain', 'image/*']);
        /* @var $file File */
        $file = $this->inputBuilderStub->last();
        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals('inputName', $this->inputBuilderStub->last()->getName());
        $this->assertEquals('text/plain,image/*', $file->getAccept());

        $this->assertCount(2, $file->getValidators());
        $this->assertInstanceOf(MimeType::class, $file->getValidators()[1]);
        $this->assertEquals(['text/plain', 'image/*'], $file->getValidators()[1]->getAllowedMimeTypes());
    }


    public function testLeftAddon()
    {
        $this->inputBuilderStub
            ->text('text')
            ->leftAddon('left');
        $this->assertEquals('left', $this->inputBuilderStub->last()->getOption('leftAddon'));

        $this->setUp();
        $this->expectException(\UForm\Builder\BuilderException::class);
        $this->inputBuilderStub->leftAddon('leftAddon');
    }

    public function testRightAddon()
    {
        $this->inputBuilderStub
            ->text('text')
            ->rightAddon('right');
        $this->assertEquals('right', $this->inputBuilderStub->last()->getOption('rightAddon'));

        $this->setUp();
        $this->expectException(\UForm\Builder\BuilderException::class);
        $this->inputBuilderStub->rightAddon('rightAddon');
    }

    public function testDisabled()
    {
        $this->inputBuilderStub
            ->text('text')
            ->disabled();
        $this->assertEquals('disabled', $this->inputBuilderStub->last()->getAttribute('disabled'));
        $this->assertInstanceOf(\UForm\Filter\RemoveValue::class, $this->inputBuilderStub->last()->getFilters()[0]);
    }

    public function testReadOnly()
    {
        $this->inputBuilderStub
            ->text('text')
            ->readOnly();
        $this->assertEquals('readonly', $this->inputBuilderStub->last()->getAttribute('readonly'));
        $this->assertInstanceOf(\UForm\Filter\RemoveValue::class, $this->inputBuilderStub->last()->getFilters()[0]);


        $this->inputBuilderStub
            ->text('text')
            ->readOnly('freeze');
        $this->assertEquals('readonly', $this->inputBuilderStub->last()->getAttribute('readonly'));
        $this->assertInstanceOf(\UForm\Filter\FreezeValue::class, $this->inputBuilderStub->last()->getFilters()[0]);
        $this->assertEquals('freeze', $this->inputBuilderStub->last()->getFilters()[0]->filter('foo'));



        $this->inputBuilderStub
            ->text('text')
            ->readOnly(0);
        $this->assertEquals('readonly', $this->inputBuilderStub->last()->getAttribute('readonly'));
        $this->assertInstanceOf(\UForm\Filter\FreezeValue::class, $this->inputBuilderStub->last()->getFilters()[0]);
        $this->assertEquals(0, $this->inputBuilderStub->last()->getFilters()[0]->filter('foo'));
    }


    public function testAttribute()
    {
        $ret = $this->inputBuilderStub
            ->text('text')
            ->attribute('foobar', 'baz');
        $this->assertEquals('baz', $this->inputBuilderStub->last()->getAttribute('foobar'));

        $this->assertSame($this->inputBuilderStub, $ret);
    }

    public function testPlaceholder()
    {
        $ret = $this->inputBuilderStub
            ->text('text')
            ->placeholder('qux');
        $this->assertEquals('qux', $this->inputBuilderStub->last()->getAttribute('placeholder'));

        $this->assertSame($this->inputBuilderStub, $ret);
    }


    public function testSubmit()
    {
        $ret = $this->inputBuilderStub
            ->submit('foo', 'bar');


        $last = $this->inputBuilderStub->last();
        $this->assertInstanceOf(Submit::class, $last);
        $this->assertEquals('foo', $last->getName());
        $this->assertEquals('bar', $last->getSubmitValue());


        $this->assertSame($this->inputBuilderStub, $ret);
    }
}
