UForm
=====

[![Latest Stable Version](https://poser.pugx.org/gsouf/uform/version)](https://packagist.org/packages/gsouf/uform)
[![Build Status](https://travis-ci.org/gsouf/UForm.svg)](https://travis-ci.org/gsouf/UForm)
[![Test Coverage](https://codeclimate.com/github/gsouf/UForm/badges/coverage.svg)](https://codeclimate.com/github/SneakyBobito/UForm/coverage)

UForm is a form validation/filtering/rendering library for PHP.


Usage
-----

### Quick start

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

<center>![bootstrap 3 example](/doc/screenshot/bootstrap3.png)</center>

### Full documentation

The full documentation is available at: [gsouf.github.io/UForm](http://gsouf.github.io/UForm)
