<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test;

use UForm\DataContext;
use UForm\Form;
use UForm\Form\Element\Primary\Input\Text;
use UForm\Validation\ValidationItem;

class ValidatorTestCase extends \PHPUnit_Framework_TestCase
{

    public function generateValidationItem($data)
    {
        $firstname = new Text("firstname");
        $lastname  = new Text("lastname");

        $form = new Form();
        $form->addElement($firstname);
        $form->addElement($lastname);
        $formContext = $form->generateContext($data);

        return new ValidationItem(
            new DataContext($data),
            $firstname,
            $formContext
        );
    }
}
