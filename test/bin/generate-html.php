#!/usr/bin/php
<?php

include __DIR__ . "/../../vendor/autoload.php";

use UForm\Builder;
use UForm\Render\Html\Bootstrap3;
use UForm\Render\Html\Foundation5;
use UForm\Render\Html\StandardHtml;


$renders = [

    "standardHtml" => new StandardHtml(),
    "bootstrap3" => new Bootstrap3(),
    "foundation5" => new Foundation5()

];

$form = Builder::init("action", "method")
    ->columnGroup()
        ->column(15)
            ->panel("Login informations")
                ->text("login", "Login")->required()->stringLength(2, 20)
                ->password("password", "Password")->required()->stringLength(2, 20)
            ->close()
        ->close()
        ->column(5)
            ->text("money", "Money (with tooltip)")->required()->rightAddon("&euro;")->tooltip("Give me your money")
        ->close()
    ->close()

    ->panel("Inlined Panel (with tooltip)")->tooltip("The following elemens are inlined")
        ->inline()
            ->text("weight", "Weight")->helper("This element is inlined")->rightAddon("g")
            ->text("inlined2", "Inlined 2")
            ->text("inlined3", "Inlined 3")
        ->close()
    ->close()
    ->tabGroup()
        ->tab("Tab with error", true)
            ->text("tab1validInput", "Valid input")
            ->text("tab1invalidInput", "invalid input")->validator(function(){return false;})
        ->close()
        ->tab("Tab (with tooltip)")->tooltip("additional informations")
            ->text("tab2validInput", "Valid input")
        ->close()
        ->tab("Tab with helptext")->helper("This tab contains some message that aims to help the user")
            ->text("tab3validInput", "Valid input")
        ->close()
    ->close()
    ->getForm();

$data = [
    "firstname" => "bart",
    "lastname" => "simpson",
    "login" => "bart",
    "password" => "somepassword"
];

$formContext = $form->validate($data);





foreach($renders as $name=>$render){
    $html = file_get_contents(__DIR__ . "/../html-skeleton/$name.html");
    $html = str_replace("{{content}}", $render->render($formContext), $html);
    file_put_contents(__DIR__ . "/../../build/$name.html", $html);
}
