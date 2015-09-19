<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Container;

use UForm\Form\Element\Container\Collection;
use UForm\Form\Element\Primary\Text;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Collection
     */
    protected $collection;

    protected $elementModel;

    public function setUp()
    {
        $this->elementModel =  new Text("textName");
        $this->collection = new Collection("collectionName", $this->elementModel);
    }

    public function testCollection()
    {
        $this->assertSame($this->elementModel, $this->collection->getElement(""));
    }
}
