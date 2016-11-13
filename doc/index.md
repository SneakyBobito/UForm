---
currentMenu: home
---

Quick start
===========

```php

use UForm\Builder;

$form = 
     Builder::init("action", "POST") // initialize the form with action and method
        // Add some input text with some validation rules
        ->text("firstname", "Firstname")->required()->stringLength(2, 20) 
        ->text("lastname", "Lastname")->required()->stringLength(2, 20)
        ->text("login", "Login")->required()->stringLength(2, 20)
        // Add an input password
        ->password("password", "Password")->required()->stringLength(2, 20)
        // Get the form instance
        ->getForm();


//If it's a post request we validate the form with the post data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $formContext = $form->validate($form->getInputFromGlobals());
    if ($formContext->isValid()) {
        $filteredData = $formContext->getData();
        // Do some logic with data
        // ...
    }
} else { // Or else we just generate a context with empty values
    $formContext = $form->generateContext([]);
}

// We want to render some html for bootstrap 3
$formRenderer = new Bootstrap3Render();
$html = $formRenderer->render($formContext);

echo $html;

```

Get more documentation from the left menu.
