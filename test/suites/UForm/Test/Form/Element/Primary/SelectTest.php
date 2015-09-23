<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Form\Element\Primary;

use UForm\Form\Element\Primary\Select;

class SelectTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Select
     */
    protected $select;


    public function setUp()
    {
        $this->select = new Select("familly");
    }

    public function testSetOptionValues()
    {

        $this->select->setOptionValues([
            "Homer" => "simpson",
            "Ned" => "flanders",

            "Kids" => [
                "Bart" => "simpson",
                "Rod" => "flanders"
            ]
        ]);

        // No selection
        $expected =
            '<select name="familly">'

                . '<option value="simpson">Homer</option>'
                . '<option value="flanders">Ned</option>'
                . '<optgroup label="Kids">'
                    . '<option value="simpson">Bart</option>'
                    . '<option value="flanders">Rod</option>'
                . '</optgroup>'

            . '</select>';
        $this->assertEquals($expected, $this->select->render([], []));

        // selection
        $expected =
            '<select name="familly">'

            . '<option value="simpson" selected="selected">Homer</option>'
            . '<option value="flanders">Ned</option>'
            . '<optgroup label="Kids">'
            . '<option value="simpson" selected="selected">Bart</option>'
            . '<option value="flanders">Rod</option>'
            . '</optgroup>'

            . '</select>';
        $this->assertEquals($expected, $this->select->render(["familly" => "simpson"], ["familly" => "simpson"]));

    }
}
