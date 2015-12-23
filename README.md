UForm
=====

[![Latest Stable Version](https://poser.pugx.org/gsouf/uform/version)](https://packagist.org/packages/gsouf/uform)
[![Build Status](https://travis-ci.org/gsouf/UForm.svg)](https://travis-ci.org/gsouf/UForm)
[![Test Coverage](https://codeclimate.com/github/gsouf/UForm/badges/coverage.svg)](https://codeclimate.com/github/SneakyBobito/UForm/coverage)

UForm is a form validation/filtering/rendering library for PHP.

The 100$ question: why another form library? Because I needed a rock solid and flexible library. Something that other libraries 
couldn't deal with (especially due to lack of flexibility in the rendering).


UForm is structured as follows
------------------------------

- A **logicless and stateless core** that defines usual form elements *(makes it rock solid)*
- A flexible **validation/filtering** workflow with translatable messages *(makes it extensible)*
- Some **HTML aware** components like fieldset, row, columns, tabs, panel... *(makes it easy to use)*
- An **extendable fluent builder** (factory) to create forms easily with **the additional needed logic** *(makes it cool to use)*
- Implementation of popular html frameworks like **Bootstrap** or **Foundation** with a custom twig workflow *(makes it sociable enough for the real world)*



Usage
-----

**Project is a work in progress** that means that doc will come when the API is frozen or more stable.

In the meanwhile here a simple example:

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



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //If its a post query we validate the form with the post data
    $formContext = $form->validate($form->getInputFromGlobals());
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

Tests
-----

The library is fully unit tested. Every bug is reproduced in the unit test and make it unreproducible for ever.
The test coverage mays not be 100% between 2 releases but release is made only when the whole library will be covered.

Known Issues
------------

### Bootstrap3 Render

- Some additional css may be need to render bootstrap3 correctly: [additional css](https://github.com/gsouf/UForm/blob/gh-pages/render/Bootstrap3.md#additional-css)

### Foundation5 Render

- Some additional css may be needed to have a proper render: [additional css](https://github.com/gsouf/UForm/blob/gh-pages/render/Foundation5.md#additional-css)
- Foundation does not support inlined elements

Thanks
------

Thanks to @andresgutierrez for the 
[Phalcon form component](https://github.com/phalcon/cphalcon/tree/master/phalcon/forms) 
that served as inspiration for this one.
