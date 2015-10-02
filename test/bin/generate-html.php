#!/usr/bin/php
<?php

include __DIR__ . "/../../vendor/autoload.php";

use UForm\Builder;
use UForm\Render\Html\Bootstrap3;
use UForm\Render\Html\StandardHtml;

$form = Builder::init("action", "method")
    ->text("firstname", "Firstname")->required()->stringLength(2, 20)->helper("This is your first name")
    ->text("lastname", "Lastname")->required()->stringLength(2, 20)
    ->text("login", "Login")->required()->stringLength(2, 20)
    ->password("password", "Password")->required()->stringLength(2, 20)
    ->text("currency", "Currency")->required()->rightAddon("&euro;")
    ->panel("Inlined Elements")
        ->inline()
            ->text("inlined1", "Inlined 1")->helper("This element is inlined")
            ->text("inlined2", "Inlined 2")
        ->close()
    ->close()
    ->tabGroup()
        ->tab("Tab 1", true)
            ->text("tab1validInput", "Valid input")
            ->text("tab1invalidInput", "invalid input")->validator(function(){return false;})
        ->close()
        ->tab("Tab 2")
            ->text("tab2validInput", "Valid input")
        ->close()
    ->close()
    ->tabGroup(["tab-style" => "pills", "tab-position" => "right", "tab-justified" => true])
        ->tab("Tab 1")
            ->text("tab1validInput", "Valid input")
        ->close()
        ->tab("Tab 2", true)
            ->text("tab2validInput", "Valid input")
        ->close()
        ->tab("Tab 3")
            ->text("tab3invalidInput", "Invalid input")->validator(function(){return false;})
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


$renders = [

    "standardHtml" => new StandardHtml(),
    "bootstrap3" => new Bootstrap3()

];


foreach($renders as $name=>$render){
    $html = file_get_contents(__DIR__ . "/../html-skeleton/$name.html");
    $html = str_replace("{{content}}", $render->render($formContext), $html);
    file_put_contents(__DIR__ . "/../../build/$name.html", $html);
}
