<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary;


use UForm\Form\Element\Primary\Select;

class SelectTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Select
     */
    protected $select;


    public function setUp(){
        $this->select = new Select("mySelect");
    }

    public function testSetOptionValues(){
    }

}
