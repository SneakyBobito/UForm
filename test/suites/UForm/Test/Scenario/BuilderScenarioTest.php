<?php
/**
 * @license see LICENSE
 */

namespace UForm\Test\Scenario;

use UForm\Builder;
use UForm\Render\Html\Bootstrap3;

/**
 * @codeCoverageIgnore
 */
class BuilderScenarioTest extends \PHPUnit_Framework_TestCase
{

    public function testBuilder()
    {
        $form = Builder::init("action", "method")
            ->text("firstname", "Firstname")->required()->stringLength(2, 20)
            ->text("lastname", "Lastname")->required()->stringLength(2, 20)
            ->text("login", "Login")->required()->stringLength(2, 20)
            ->password("password", "Password")->required()->stringLength(2, 20)
            ->getForm();

        $data = [
            "firstname" => "bart",
            "lastname" => "simpson",
            "login" => "bart",
            "password" => "****"
        ];

        $formContext = $form->validate($data);


        $render = new Bootstrap3();
        $html = $render->render($formContext);

        $this->assertInternalType("string", $html);

    }
}
