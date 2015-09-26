<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\DataContext;
use UForm\Form;
use UForm\Form\Element\Primary\Input\Text;
use UForm\ValidationItem;

class ValidatorTestCase extends \PHPUnit_Framework_TestCase
{

    public function generateValidationItem($data)
    {
        $element = new Text("firstname");

        $form = new Form();
        $form->addElement($element);
        $formContext = $form->generateContext($data);

        return new ValidationItem(
            new DataContext($data),
            $element,
            $formContext
        );
    }
}
