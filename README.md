UForm
=====

[![Build Status](https://travis-ci.org/gsouf/UForm.svg)](https://travis-ci.org/gsouf/UForm)
[![Test Coverage](https://codeclimate.com/github/SneakyBobito/UForm/badges/coverage.svg)](https://codeclimate.com/github/SneakyBobito/UForm/coverage)
[![Code Climate](https://codeclimate.com/github/SneakyBobito/UForm/badges/gpa.svg)](https://codeclimate.com/github/SneakyBobito/UForm)
[![Latest Stable Version](https://poser.pugx.org/gsouf/uform/version)](https://packagist.org/packages/gsouf/uform)


UForm is a form validation/filtering/rendering library that solve all the problems you encounter with web forms.

Why another form library? Because the other I tried had limitations. This library is an effort to make something more flexible and at the same time very concrete. 

Why concrete? Because a form library should be as simple as possible in many aspects : creation, validation, data binding, rendering, etc...

Top Features
------------

- Fluent form builder to make form creation as painless as possible
- Structure aware form: you can structure your inputs in columns, tabs, panels... with no impact of the data processing
- Flexible and extensible rendering: you are free to use the native html render, the bootstrap render, the foundation render, or to write your one render from scratch or by extending an existing one.
- Validation message translation (WIP)


Usage
-----

**Project is under heavy development** and doc will come when the API is frozen or more stable.

Here is an example of how the library works :

```php

use UForm\Builder;


$form = 
     // initialize the form with aciton and method
    Builder::init("action", "POST")
     // Add some input text with some validation rules
    ->text("firstname", "Firstname")->required()->stringLength(2, 20) 
    ->text("lastname", "Lastname")->required()->stringLength(2, 20)
    ->text("login", "Login")->required()->stringLength(2, 20)
    // Add an input password
    ->password("password", "Password")->required()->stringLength(2, 20)
    // Get the form instance
    ->getForm();



if (isset($_POST)) {
    //If its a post query we validate the form with the post data
    $formContext = $form->validate($_POST);
    if ($formContext->isValid()) {
        $filteredData = $formContext->getData();
        // Do some logic with data
    }
} else {
    // Or else we just generate a context with empty values
    $formContext = $form->generateContext([]);
}

// We want to render some html for bootstrap 3
$render = new Bootstrap3Render();
$html = $render->render($formContext);

echo $html;

```



Thanks
------

Thanks to @andresgutierrez for the 
[Phalcon form component](https://github.com/phalcon/cphalcon/tree/master/phalcon/forms) 
that served as inspiration for this one.
