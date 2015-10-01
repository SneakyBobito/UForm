#!/usr/bin/php
<?php

include __DIR__ . "/../../vendor/autoload.php";

use UForm\Builder;
use UForm\Render\Bootstrap3Render;
use UForm\Render\StandardHtmlRender;

$form = Builder::init("action", "method")
    ->text("firstname", "Firstname")->required()->stringLength(2, 20)
    ->text("lastname", "Lastname")->required()->stringLength(2, 20)
    ->text("login", "Login")->required()->stringLength(2, 20)
    ->password("password", "Password")->required()->stringLength(2, 20)
    ->text("currency", "Currency")->required()->rightAddon("&euro;")
    ->panel("Inlined Elements")
        ->inline()
            ->text("inlined1", "Inlined 1")
            ->text("inlined2", "Inlined 2")
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

    "standardHtml" => new StandardHtmlRender(),
    "bootstrap3" => new Bootstrap3Render()

];


foreach($renders as $name=>$render){
    $html = file_get_contents(__DIR__ . "/../html-skeleton/$name.html");
    $html = str_replace("{{content}}", $render->render($formContext), $html);
    file_put_contents(__DIR__ . "/../../build/$name.html", $html);
}
