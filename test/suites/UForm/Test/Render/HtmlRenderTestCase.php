<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Render;

use UForm\Render\AbstractHtmlRender;

abstract class HtmlRenderTestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AbstractHtmlRender
     */
    protected $render;

    public function setUp()
    {
        $this->render = $this->createRender();
    }

    /**
     * @return AbstractHtmlRender
     */
    abstract public function createRender();

    public function testDirectoryExistence()
    {
        $files = $this->render->getTemplatesPathes();

        foreach ($files as $file) {
            $this->assertTrue(file_exists($file), "template directory $file does not exist");
            $this->assertTrue(is_dir($file), "the template path $file is not a directory");
        }

    }

    /**
     * Test if every non abstract elements have a render template for the current render implementation
     */
    public function testTemplatesImplementation()
    {

        $treeBuilder = new  \UForm\Doc\ElementTreeBuilder([
            __DIR__ . '/../../../../../src/UForm/Form' => 'UForm\Form'
        ]);
        $tree = $treeBuilder->getTree();

        $it = new \RecursiveIteratorIterator(new \UForm\Doc\ElementTreeRecursiveIterator($tree));
        foreach ($it as $nodeInfo) {
            /* @var $nodeInfo \UForm\Doc\NodeInfo */
            $reflection = new \ReflectionClass($nodeInfo->node->getClassName());
            if (!$reflection->isAbstract() && !$reflection->implementsInterface("UForm\Form\Element\Drawable")) {
                $semanticTypesObjects = $nodeInfo->node->getSemanticTypes();

                $semanticTypes = [];
                foreach ($semanticTypesObjects as $s) {
                    $semanticTypes[] = $s->getName();
                }

                try {
                    $template = $this->render->resolveTemplate($semanticTypes);
                    $this->assertInstanceOf("Twig_TemplateInterface", $template);
                } catch (\Exception $e) {
                    $className = $nodeInfo->node->getClassName();
                    $renderName = $this->render->getRenderName();
                    $this->fail("Class $className has no template for render $renderName : " . $e->getMessage());
                }
            }


        }
    }
}
